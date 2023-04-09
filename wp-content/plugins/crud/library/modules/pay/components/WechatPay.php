<?php


namespace crud\modules\pay\components;

use crud\models\wp\WpUsers;
use crud\modules\pay\behaviors\PayBehavior;
use Yii;
use \yii\helpers\ArrayHelper;
use Exception;
use yii\base\Component;
use WeChatPay\Builder;
use WeChatPay\Crypto\Rsa;
use GuzzleHttp\Middleware;
use WeChatPay\Util\PemUtil;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use WeChatPay\ClientDecoratorInterface;
use WeChatPay\Crypto\AesGcm;

/**
 * Class WechatPay
 *
 * @property WpUsers  $user
 * @property-read crud\modules\pay\events\PayEvent $payEvent
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

    private $_user;

    public function behaviors(){
        return [
//            PayBehavior::className()
        ];
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
//         $this->payEvent->pal_type =$palType;
//         $this->payEvent->user_id =$userId;
//         $this->payEvent->subject = $subject;
//         $this->payEvent->order_id = $orderId;
//         $this->payEvent->total_amount =$money;
//         $this->payEvent->notify_url = $notifyUrl;
//         $this->payEvent->return_url  = $returnUrl;
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
//             $instance = $this->client();
//             $this->trigger('submit');
             return  $result;
         }catch (Exception $exception){
//             $this->on('submit');
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
             $result = json_decode($client
                 ->chain('v3/pay/transactions/jsapi')
                 ->post(['json' => $data])->getBody()->getContents(),true);
             if(isset($result['prepay_id'])){
                 $appid = $this->appid;
                 $timeStamp= (string) time();
                 $nonceStr= generateUuid(32);
                 $package='prepay_id='.$result['prepay_id'];
                 $str =join(PHP_EOL,[$appid,$timeStamp,$nonceStr,$package]).PHP_EOL;
                 logObject($str);

                 $paySign =$this->sign($str);
                 logObject($this-> ensign($str, $paySign ));
                 $signType ='RSA';

                 return [
                     'timeStamp'=>$timeStamp,
                     'nonceStr'=>$nonceStr,
                     'package'=>$package,
                     'signType'=>$signType,
                     'paySign'=>$paySign,
//                     'prepay_id'=>$result['prepay_id']
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
     * @return mixed
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

     }

     public function test()
     {

     }

     public function remit($orderId, $orderMoney, $toUser, $toUserName, $orderTitle = "", $orderRemark = "", $identity_type = 'ALIPAY_LOGON_ID', $options = [])
     {

     }


     public function sign($signStr){
         // 从本地文件中加载「商户API私钥」，「商户API私钥」会用来生成请求的签名
         $merchantPrivateKeyFilePath = 'file://'.Yii::getAlias($this->merchantPrivateKeyFilePath);
         $privateKey = Rsa::from($merchantPrivateKeyFilePath, Rsa::KEY_TYPE_PRIVATE);
         $pkey= openssl_pkey_get_private($privateKey);//$privateKey为私钥字符串
         openssl_private_encrypt($signStr, $encryptedData, $pkey);
        return base64_encode($encryptedData);
     }

     public function ensign($key,$signStr){
         $merchantPublicKeyFilePath = 'file://'.Yii::getAlias($this->merchantPublicKeyFilePath);
         $publicKey = Rsa::from($merchantPublicKeyFilePath, Rsa::KEY_TYPE_PUBLIC);
         logObject($publicKey);
//         $pkey = openssl_pkey_get_public($publicKey);//公钥字符串
//         $verify = openssl_verify($key, base64_decode($signStr),$publicKey);//$key为需要签名的字符串//$signature为签名后字符串
//         openssl_free_key($pkey);
//         return $verify ;
     }
 }