<?php
namespace crud\modules\pay\components;

use Yii;
use Exception;
use SodiumException;
use WeChatPay\Builder;
use yii\base\Component;
use WeChatPay\Crypto\Rsa;
use GuzzleHttp\Middleware;
use WeChatPay\Util\PemUtil;
use crud\models\wp\WpUsers;
use WeChatPay\Crypto\AesGcm;
use \yii\helpers\ArrayHelper;
use crud\modules\pay\events\PayEvent;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use crud\modules\pay\behaviors\PayBehavior;
/**
 * Class WechatPay
 *
 * @property-read  string $wechatPayNo 微信平台证书序列号
 * @property WpUsers  $user
 * @property PayEvent $payEvent 事件处理器
 */
class WechatPay extends Component implements Pay
{
    public $appid;
    // apiV3key
    public $apiV3Key;
    // 商户号
    public $merchantId;
    //商户API证书序列号
    public $merchantCertificateSerial;
    //商户私钥文件路径
    public $merchantPrivateKeyFilePath;
    //商户公钥文件路径
    public $merchantPublicKeyFilePath;
    // 微信支付平台证书文件路径
    public $platformCertificateFilePath;

    // 默认异步通知
    public $notifyUrl;
    // 同步跳转
    public $returnUrl;

    private $_user;
    public function behaviors(){
        return [
            PayBehavior::className()
        ];
    }

    public function getWechatPayNo(){
        $platformCertificateFilePath = 'file://'.Yii::getAlias($this->platformCertificateFilePath);

        // 从「微信支付平台证书」中获取「证书序列号」
        return PemUtil::parseCertificateSerialNo($platformCertificateFilePath);
    }

    /**
     * @param string $encryptType
     * @return \WeChatPay\BuilderChainable
     */
     public function client($encryptType=""){
         // 商户号
         $merchantId = $this->merchantId;

        // 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
         $merchantPrivateKeyFilePath = 'file://'.Yii::getAlias($this->merchantPrivateKeyFilePath);
         $merchantPrivateKeyInstance = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);

        // 「商户API证书」的「证书序列号」
         $merchantCertificateSerial =  $this->merchantCertificateSerial;

         // 从本地文件中加载「微信支付平台证书」，用来验证微信支付应答的签名
         $platformCertificateFilePath = 'file://'.Yii::getAlias($this->platformCertificateFilePath);
         $platformPublicKeyInstance = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);

        // 从「微信支付平台证书」中获取「证书序列号」
         $platformCertificateSerial = PemUtil::parseCertificateSerialNo($platformCertificateFilePath);

        // 构造一个 APIv3 客户端实例
         return Builder::factory([
             'mchid'      => $merchantId,
             'serial'     => $merchantCertificateSerial,
             'privateKey' => $merchantPrivateKeyInstance,
             'certs'      => [
                 $platformCertificateSerial => $platformPublicKeyInstance,
             ],
         ]);
     }
    /**
     * 获取「微信支付平台证书」
     *
     * @return mixed
     */
     public function certificates(){
         $basePath = Yii::getAlias('@palKey');
         $outputDir = Yii::getAlias(get_option('crud_group_wechatpay_platformCertificateFilePath', '@palKey/wechat/wechatRoot.pem'));
         if (empty($outputDir)) {
             $outputDir = Yii::getAlias('@palKey/wechat/wechatRoot_'.time().'.pem');
         }
         if (file_exists($outputDir)) {
             $outputDir = preg_replace('/\d+\.pem/i',time().".pem",$outputDir);
         }
         $outputDir = 'file://' . $outputDir;
         static $certs = ['any' => null];
         $apiv3Key = $this->apiV3Key;
         $instance = Builder::factory([
             'mchid' => $this->merchantId,
             'serial' => $this->merchantCertificateSerial,
             'privateKey' => file_get_contents('file://' . Yii::getAlias($this->merchantPrivateKeyFilePath)),
             'certs' => &$certs,
             'base_uri' => 'https://api.mch.weixin.qq.com/',
         ]);
         $stack = $instance->getDriver()->select('v3')->getConfig('handler');

         $afterFunctions = function (ResponseInterface $response) use ($apiv3Key, &$certs) {
             $body = (string)$response->getBody();
             $json = \json_decode($body);
             $data = \is_object($json) && isset($json->data) && \is_array($json->data) ? $json->data : [];
             \array_map(static function ($row) use ($apiv3Key, &$certs) {
                 $cert = $row->encrypt_certificate;
                 $certs[$row->serial_no] = AesGcm::decrypt($cert->ciphertext, $apiv3Key, $cert->nonce, $cert->associated_data);
             }, $data);
             return $response;
         };
         $beforeFunctions = function (ResponseInterface $response) use ($outputDir, &$certs, $basePath) {
             $return = [
                 'code' => 0,
                 'message' => 'ok',
                 'data' => ''
             ];
             $body = (string)$response->getBody();
             $json = json_decode($body);
             $data = is_object($json) && isset($json->data) && \is_array($json->data) ? $json->data : [];
             array_walk($data, static function ($row, $index, $certs) use ($outputDir, $basePath, &$return) {
                 $serialNo = $row->serial_no;
                 if (file_put_contents($outputDir, $certs[$serialNo])) {
                     $return['code'] = 1;
                     $return['data'] = str_replace('file://' . $basePath, "@palKey", $outputDir);
                     update_option('crud_group_wechatpay_platformCertificateFilePath', $return['data']);
                 }
             }, $certs);
             return $return;
         };
         $debugFunction = function ($exception){
             $return = [
                 'code' => 0,
                 'message' => $exception->getMessage(),
                 'data' => '',
             ];
             if ($exception instanceof RequestException && $exception->hasResponse()) {
                 /** @var ResponseInterface $response */
                 $response = $exception->getResponse();
                 $return['data'] = $response->getBody();
             }
             $return['trace'] = $exception->getTrace();
             return $return;
         };

         // 在'verifier'执行之前，解密平台证书并将其放入'$certs'引用中
         $stack->after('verifier', Middleware::mapResponse($afterFunctions, 'injector'));
         // 执行'verifier'后，将平台证书写入磁盘
         $stack->before('verifier', Middleware::mapResponse($beforeFunctions, 'recorder'));
         return $instance->chain('v3/certificates')
             ->getAsync()
             ->otherwise($debugFunction)
             ->wait();
    }

    /**
     * @param 订单场景 $palType
     * @param 用户id|int|null $userId
     * @param 订单号|string $orderId
     * @param 订单标题|string $subject
     * @param 订单金额|number $money
     * @param string $notifyUrl
     * @param string $returnUrl
     * @param array $options
     * @return mixed|ResponseInterface
     */
     public function submit($palType,$userId ,$orderId, $subject, $money, $notifyUrl = '', $returnUrl = '', $options = [])
     {
         $result ='';
         $notifyUrl = empty($notifyUrl) ? $this->notifyUrl : $notifyUrl;
         $returnUrl = empty($returnUrl) ? $this->returnUrl : $returnUrl;
         $this->payEvent->pal_type =$palType;
         $this->payEvent->user_id =$userId;
         $this->payEvent->subject = $subject;
         $this->payEvent->order_id = $orderId;
         $this->payEvent->total_amount =$money;
         $this->payEvent->notify_url = $notifyUrl;
         $this->payEvent->return_url  = $returnUrl;
         $this->trigger(PayBehavior::EVENT_BEFORE_SUBMIT);
         if($this->payEvent->model->validate()){
             try{
                 if ($palType == 'wechatJsApi') {
                     $result = $this->submitJsApi($userId,$orderId, $subject, $money, $notifyUrl, $returnUrl, $options);
                 } elseif ($palType == 'wechatApp') {
                     $result = $this->submitApp($orderId, $subject, $money, $notifyUrl, $returnUrl, $options);
                 } elseif ($palType == 'wechatH5') {
                     $result = $this->submitH5($orderId, $subject, $money, $notifyUrl, $returnUrl, $options);
                 } elseif ($palType == 'wechatNative') {
                     $result = $this->submitNative($orderId, $subject, $money, $notifyUrl, $returnUrl, $options);
                 }
                 $this->trigger(PayBehavior::EVENT_AFTER_SUBMIT);
                 return  $result;
             }catch (\Exception $exception){

             }

         }else{
             throw new Exception(self::join($this->payEvent->model->errors));
         }

     }
    /**
     * @param $userId
     * @param $orderId
     * @param $subject
     * @param $money
     * @param $notifyUrl
     * @param $returnUrl
     * @param $options
     * @return ResponseInterface
     */
     public function submitJsApi($userId,$orderId, $subject, $money, $notifyUrl, $returnUrl , $options=[]){
         $client = $this->client();
         $data =[
             "mchid" => $this->merchantId,
             "out_trade_no" => $orderId,
             "appid" => $this->appid,
             "description" => $subject,
             "notify_url" =>$notifyUrl,
             "amount" => [
                 "total" => ( float) $money * 100,
                 "currency" => "CNY"
             ],
             "payer" => [
                 "openid" => $this->getUserIdByOpenId($userId)
             ]
         ];

         $data = ArrayHelper::merge($data,$options);
         try {
             $result = $client
                 ->chain('v3/pay/transactions/jsapi')
                 ->post(['json' => $data])
                 ->getBody()
                 ->getContents();
             $result =json_decode($result,true);
             if(isset($result['prepay_id'])){
                 $appid = $this->appid;
                 $timeStamp= (string) time();
                 $nonceStr= generateUuid(32);
                 $package='prepay_id='.$result['prepay_id'];
                 $str =join(PHP_EOL,[$appid,$timeStamp,$nonceStr,$package]).PHP_EOL;

                 $paySign =$this->sign($str);

                 $signType ='RSA';

                 return [
                     'timeStamp'=>$timeStamp,
                     'nonceStr'=>$nonceStr,
                     'package'=>$package,
                     'signType'=>$signType,
                     'paySign'=>$paySign,
                 ];

             }else{
                 return false;
             }

         } catch (\Exception $e) {
             // 进行错误处理
             $message = $e->getMessage();
             if ($e instanceof \GuzzleHttp\Exception\RequestException && $e->hasResponse()) {
                 $r = $e->getResponse();
                 $code = $r->getStatusCode() . ' ' . $r->getReasonPhrase();
                 $data = $r->getBody();
             }
             return [
                 'code'=>isset( $code)? $code:"",
                 'message'=>$message,
                 'data'=>$data,
                 'trace'=>$e->getTrace()
             ];
         }

     }
    /**
     * @param $userId
     * @param $orderId
     * @param $subject
     * @param $money
     * @param $notifyUrl
     * @param $returnUrl
     * @param $options
     * @return ResponseInterface
     */
     public function submitApp($userId,$orderId, $subject, $money, $notifyUrl, $returnUrl , $options){
         $client = $this->client();
         $data =[
             "mchid" => $this->merchantId,
             "out_trade_no" => $orderId,
             "appid" => $this->appid,
             "description" => $subject,
             "notify_url" =>$notifyUrl,
             "amount" => [
                 "total" => ( int) $money * 100,
                 "currency" => "CNY"
             ],
         ];
         $data = ArrayHelper::merge($data,$options);
         return $client->chain('v3/pay/transactions/app')
             ->post(['json' => $data]);
     }

    /**
     * @param $userId
     * @param $orderId
     * @param $subject
     * @param $money
     * @param $notifyUrl
     * @param $returnUrl
     * @param $options
     * @return ResponseInterface
     */
     public function submitH5($userId,$orderId, $subject, $money, $notifyUrl, $returnUrl , $options){
         $client = $this->client();
         $data = [
             "mchid" => $this->merchantId,
             "out_trade_no" => $orderId,
             "appid" => $this->appid,
             "description" => $subject,
             "notify_url" => $notifyUrl,
             "amount" => [
                 "total" => ( int)$money * 100,
                 "currency" => "CNY"
             ],
             'scene_info' => [
                 "payer_client_ip" => Yii::$app->request->getUserIP(),
                 "h5_info" => [
                     "type" => "Wap"
                 ]
             ]
         ];
         $data = ArrayHelper::merge($data, $options);
         return $client->chain('/v3/pay/transactions/h5')
             ->post(['json' => $data]);
     }
    /**
     * @param $userId
     * @param $orderId
     * @param $subject
     * @param $money
     * @param $notifyUrl
     * @param $returnUrl
     * @param $options
     * @return ResponseInterface
     */
     public function submitNative($userId,$orderId, $subject, $money, $notifyUrl, $returnUrl , $options){
         $client = $this->client();
         $data =[
             "mchid" => $this->merchantId,
             "out_trade_no" => $orderId,
             "appid" => $this->appid,
             "description" => $subject,
             "notify_url" =>$notifyUrl,
             "amount" => [
                 "total" => ( int) $money * 100,
                 "currency" => "CNY"
             ],
         ];
         $data = ArrayHelper::merge($data,$options);
         return $client->chain('v3/pay/transactions/native')
             ->post(['json' => $data]);
     }
    /**
     * 通过用户id 返回openid
     * @param string $openid
     * @return mixed
     */
    private function getUserIdByOpenId($openid=''){
        return  $this->_user->Applet_openid;
    }
    /**
     * @param $user
     * @return void
     */
    public function setUser(&$user){
         $this->_user =$user;
    }

     public function select($orderId, $number, $options = [])
     {

     }

     public function close($orderId, $number, $options = [])
     {

     }

     public function refund($orderId, $number, $money, $refund_reason = '', $out_request_no, $options = [])
     {

     }

     public function refundSelect($orderId, $number, $refund_reason, $options = [])
     {

     }

     public function notify($data)
     {
         wp_mail('757402123@qq.com','post',print_r( $data,true));
         $original_type =$data['resource']['original_type'];
         $algorithm =$data['resource']['algorithm'];
         $ciphertext =$data['resource']['ciphertext'];
         $associated_data =$data['resource']['associated_data'];
         $nonce =$data['resource']['nonce'];
         $res = json_decode( $this->decryptToString($associated_data, $nonce,$ciphertext),true);
         // 订单id
         $this->payEvent->order_id = $res['out_trade_no'];
         // 流失号
         $this->payEvent->trade_no = $res['transaction_id'];
         // 支付金额
         $this->payEvent->receipt_amount = $res['amount']['payer_total'] /100;
         if($res['trade_state']=='SUCCESS'){
             $this->payEvent->status =1;
         }
         $this->trigger(PayBehavior::EVENT_BEFORE_NOTIFY);
         wp_mail('757402123@qq.com','微信',print_r( $res,true));
     }

     public function test()
     {

     }

     public function remit($orderId, $orderMoney, $toUser, $toUserName, $orderTitle = "", $orderRemark = "", $identity_type = 'ALIPAY_LOGON_ID', $options = [])
     {

     }
    /**
     * 签名
     * @param $signStr
     * @return string
     */
     public function sign($signStr){
         $merchantPrivateKeyFilePath = 'file://'.Yii::getAlias($this->merchantPrivateKeyFilePath);
         $privateKey = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);
         $key = openssl_get_privatekey($privateKey);
         openssl_sign($signStr, $signature, $key, "SHA256");
         openssl_free_key($key);
        return base64_encode($signature);
     }

    /**
     * 使用公钥验证签名
     * @param $signStr
     * @param $sign
     * @return false|int
     */
     public function  VerifySign($signStr,$sign){
         $platformCertificateFilePath = 'file://'.Yii::getAlias($this->platformCertificateFilePath);
         $publicKey = Rsa::from($platformCertificateFilePath, Rsa::KEY_TYPE_PUBLIC);
         $key = openssl_get_publickey($publicKey);
         $ok = openssl_verify($signStr,base64_decode($sign), $key, 'SHA256');
         openssl_free_key($key);
         return $ok;
    }

    public function checkSign($params,$encryptType=''){
        $request=Yii::$app->request;
        $header =$request->headers;

        $body = file_get_contents('php://input');

        $fields =[
            // 微信平台证书系列号
            'Wechatpay-Serial',
            // 时间
            'Wechatpay-Timestamp',
            // 随机字符串
            "Wechatpay-Nonce",
            // 应答签名签名
            'Wechatpay-Signature'
        ];

        foreach ($fields as $field){
            if(!isset($header[$field]) or empty($header[$field])){
                http_response_code(500);
                exit(json_encode(['code'=>'FAIL', "message"=>"$field:丢失"]));
            }
        }

        if( ($this->wechatPayNo !== $header['Wechatpay-Serial'])){
            http_response_code(500);
            exit(json_encode(['code'=>'FAIL', "message"=>"微信平台证书系列号错误"]));
        }

        $WechatpayTimestamp =$header['Wechatpay-Timestamp'];
        $WechatpayNonce =$header["Wechatpay-Nonce"];
        $WechatpaySignature =$header['Wechatpay-Signature'];

        $signStr = join(PHP_EOL,[$WechatpayTimestamp,$WechatpayNonce,$body]).PHP_EOL;
        $ok =$this->VerifySign($signStr,$WechatpaySignature );
        wp_mail('757402123@qq.com','验证签名',print_r(['is_ok'=>$ok],true));
        if(!$ok){
            http_response_code(500);
            exit(json_encode(['code'=>'FAIL', "message"=>"签名验证失败"]));
        }
    }
    /**
     * @param $associatedData
     * @param $nonceStr
     * @param $ciphertext
     * @return bool|string
     * @throws SodiumException
     */
    public function decryptToString($associatedData, $nonceStr, $ciphertext) {
        $ciphertext = \base64_decode($ciphertext);
        if (strlen($ciphertext) <= 16) {
            return false;
        }

        // ext-sodium (default installed on >= PHP 7.2)
        if (function_exists('\sodium_crypto_aead_aes256gcm_is_available') &&
            \sodium_crypto_aead_aes256gcm_is_available()) {
            return \sodium_crypto_aead_aes256gcm_decrypt(
                $ciphertext, $associatedData, $nonceStr,$this ->apiV3Key
            );
		}

        // ext-libsodium (need install libsodium-php 1.x via pecl)
        if (function_exists('\Sodium\crypto_aead_aes256gcm_is_available') &&
            \Sodium\crypto_aead_aes256gcm_is_available()) {
            return \Sodium\crypto_aead_aes256gcm_decrypt(
                $ciphertext, $associatedData, $nonceStr, $this ->apiV3Key
            );
		}

        // openssl (PHP >= 7.1 support AEAD)
        if (
            PHP_VERSION_ID >= 70100 &&
            in_array('aes-256-gcm', \openssl_get_cipher_methods())) {
            $ctext = substr($ciphertext, 0, -16);
            $authTag = substr($ciphertext, -16);

            return \openssl_decrypt(
                $ctext, 'aes-256-gcm',
                $this ->apiV3Key, \OPENSSL_RAW_DATA, $nonceStr,
				$authTag, $associatedData);
		}

        throw new \RuntimeException('AEAD_AES_256_GCM需要PHP 7.1以上或者安装libsodium-php');
    }

    public static function join($error){
         $errorStr ='';
         foreach ($error as $key =>$value){
             $errorStr .= $key.":".join('.',$value).PHP_EOL;
         }
         return $errorStr;
    }
 }