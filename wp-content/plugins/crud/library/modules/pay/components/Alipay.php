<?php
namespace crud\modules\pay\components;

use Yii;
use Exception;
use SimpleXMLElement;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use crud\modules\pay\events\PayEvent;
use shiguangxiaotou\alipay\AopClient;
use shiguangxiaotou\alipay\AlipayConfig;
use shiguangxiaotou\alipay\AopCertClient;
use crud\modules\pay\behaviors\PayBehavior;
use shiguangxiaotou\alipay\request\AlipayTradeCloseRequest;
use shiguangxiaotou\alipay\request\AlipayTradeQueryRequest;
use shiguangxiaotou\alipay\request\AlipayTradeRefundRequest;
use shiguangxiaotou\alipay\request\AlipayTradeWapPayRequest;
use shiguangxiaotou\alipay\request\AlipayTradePagePayRequest;
use shiguangxiaotou\alipay\request\AlipayFundTransUniTransferRequest;
use shiguangxiaotou\alipay\request\AlipayTradeFastpayRefundQueryRequest;
use shiguangxiaotou\alipay\request\AlipayDataDataserviceBillDownloadurlQueryRequest;

/**
 * Class Alipay
 *
 * @property PayEvent $payEvent 事件处理器
 * @package crud\modules\pay\components
 */
class Alipay extends Component implements Pay
{

    // appID
    public $appId;
    // 应用名称
    public $appName;
    // 绑定的商家账号(PID)
    public $pid;
    //支付宝网关url
    public $alipayUli='https://openapi.alipaydev.com/gateway.do';
    //支付网关
    public $gateway;
    // 授权回调url
    public $authorizationCallbackUil;
    // 接口加密方式
    public $encryptType=true;
    // 接口加密算法
    public $signType='RSA2';
    // 接口内容加密方式
    public $contentEncryptType=true;
    // 接口内容加解密密钥
    public $contentSecretKey;

    // 默认异步通知
    public $notifyUrl;
    // 同步跳转
    public $returnUrl;

    // +----------------------------------------------------------------------
    // ｜密钥模式
    // +----------------------------------------------------------------------
    // ｜应用私钥,应用公钥,支付宝公钥
    // +----------------------------------------------------------------------
    public $appPrivateKey; // 应用私钥
    public $appPublicKey;// 应用公钥
    public $alipayPublicKey; // 支付宝公钥

    // +----------------------------------------------------------------------
    // ｜证书模式
    // +----------------------------------------------------------------------
    // ｜应用私钥,应用公钥,应用公钥证书,支付宝公钥证书,支付宝根证书
    // +----------------------------------------------------------------------
    //public $appPrivateKey;// 应用私钥
    //public $appPublicKey;// 应用公钥
    public $appPublicCert;// 应用公钥证书
    public $alipayPublicCert;//支付宝公钥证书
    public $alipayRootCert;//支付宝根证书

    /**
     * @return array
     */
    public function behaviors(){
        return [
            PayBehavior::className()
        ];
    }

    public function pathInit(){
        $attr =[
           'contentSecretKey',
            'appPrivateKey',
            'appPublicKey',
            'alipayPublicKey',
            'appPublicCert',
            'alipayPublicCert',
            'alipayRootCert',
        ];
        foreach ( $attr as $value){

            if (!empty($this->$value) and substr($this->$value,0,1) =="@" ){
                $this->$value = Yii::getAlias($this->$value);
            }
        }
    }

    public function client($encryptType=""){
        $this->pathInit();
        if(empty($encryptType)){
            $encryptType = $this->encryptType;
        }
        if($encryptType){
            $config =new  AlipayConfig();
            $config->setAppId($this->appId);
            $config->setCharset("utf-8");
            $config->setFormat("json");
            $config->setSignType($this->signType);
            $config->setServerUrl($this->alipayUli);
            $config->setPrivateKey(str_replace(PHP_EOL,"",file_get_contents($this->appPrivateKey)));
            $config->setAlipayPublicKey($this->appPublicKey);

            return new AopClient ($config);
        }else{
            $alipayConfig = new AlipayConfig();
            $alipayConfig->setAppId($this->appId);
            $alipayConfig->setCharset("utf-8");
            $alipayConfig->setFormat("json");
            $alipayConfig->setSignType($this->signType);
            $alipayConfig->setServerUrl($this->alipayUli);
            $alipayConfig->setPrivateKey(str_replace(PHP_EOL,"",file_get_contents($this->appPrivateKey)));
            // content 和 path 只需要设置一个即可
            $alipayConfig->setAppCertPath($this->appPublicCert);
            //$alipayConfig->setAppCertContent()
            $alipayConfig->setAlipayPublicCertPath($this->alipayPublicCert);
            //$alipayConfig->setAlipayPublicCertContent()
            $alipayConfig->setRootCertPath($this->alipayRootCert);
            //$alipayConfig->setRootCertContent()
            return  new AopCertClient ($alipayConfig);
        }
    }
    /**
     * 下单
     *
     * @param string $palType
     * @param integer $userId
     * @param string|unll $orderId
     * @param string|unll $subject
     * @param float $money
     * @param string|unll $notifyUrl
     * @param string|unll $returnUrl
     * @param array| $options
     * @return 提交表单HTML文本|构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）|string|void
     * @throws Exception
     */
    public function submit( $palType ,$userId, $orderId, $subject, $money, $notifyUrl='', $returnUrl='', $options=[])
    {
        $notifyUrl = empty($notifyUrl) ? $this->notifyUrl : $notifyUrl;
        $returnUrl = empty($returnUrl) ? $this->returnUrl : $returnUrl;
        $result ='';
        $this->payEvent->pal_type =$palType;
        $this->payEvent->user_id =$userId;
        $this->payEvent->subject = $subject;
        $this->payEvent->order_id = $orderId;
        $this->payEvent->total_amount =$money;
        $this->payEvent->notify_url = $notifyUrl;
        $this->payEvent->return_url  = $returnUrl;
        $this->trigger(PayBehavior::EVENT_BEFORE_SUBMIT);

        if($this->payEvent->model->validate()){
                if($palType=="aliPayPc"){
                    $result=  $this->submitPc($orderId,$subject,$money,$notifyUrl,$returnUrl,$options);
                }elseif ($palType =="aliPayWap"){
                    $result=  $this->submitWap($orderId,$subject,$money,$notifyUrl,$returnUrl,$options);
                }
                $this->trigger(PayBehavior::EVENT_AFTER_SUBMIT);
                return  $result;
        }else{
            throw new Exception(self::join($this->payEvent->model->errors));
        }

    }

    /**
     * 订单查询
     * 商家订单号,支付宝流水号不能同时为空
     *
     * @param string $orderId  商家订单号
     * @param string $number 支付宝交易流水号
     * @param array $options
     * @return false|mixed
     * @throws Exception
     */
    public function select($orderId,$number="",$options=[]){
        if(empty($orderId) and empty($number)){
            return false;
        }
        $aop = $this->client();
        $params =[
            'out_trade_no'=>$orderId,
            'trade_no'=>$number,
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request = new AlipayTradeQueryRequest();
        $request->setBizContent( json_encode( $params));
        $result = $aop->execute ( $request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $result->$responseApiName;
    }

    /**
     * 订单关闭
     * 商家订单号,支付宝流水号不能同时为空
     * @param $orderId
     * @param $number
     * @param array $options
     * @return false|mixed
     * @throws Exception
     */
    public function close($orderId,$number,$options=[])
    {
        if((empty($orderId) and empty($number)) or (empty($money) or ($money <=0))){
            return false;
        }
        $aop = $this->client();
        $params =[
            'out_trade_no'=>$orderId,
            'trade_no'=>$number,
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request = new AlipayTradeCloseRequest();
        $request->setBizContent( json_encode( $params));
        $result = $aop->execute ( $request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $result->$responseApiName;
    }

    /**
     * 订单退款
     * 商家订单号,支付宝流水号不能同时为空
     *
     * @param 商家订单号 $orderId
     * @param 支付宝流水号 $number
     * @param 退款金额 $money
     * @param 退款原因|string|unll $refund_reason
     * @param 退款请求号|string|null $out_request_no
     * @param array $options
     * @return false|mixed
     * @throws Exception
     */
    public function refund($orderId,$number,$money,$refund_reason ='',$out_request_no='',$options=['query_options'=>'refund_detail_item_list'])
    {
        if((empty($orderId) and empty($number)) or (empty($money) or ($money <=0))){
            return false;
        }
        $aop = $this->client();
        $params =[
            'out_trade_no'=>$orderId,
            'trade_no'=>$number,
            'refund_amount'=>$money
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request = new AlipayTradeRefundRequest();
        $request->setBizContent( json_encode( $params));
        $result = $aop->execute ( $request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $result->$responseApiName;
    }

    /**
     * @param 商家订单号 $orderId
     * @param 支付宝流水号 $number
     * @param 退款请求号|string $refund_reason
     * @param array $options
     * @return false|SimpleXMLElement
     * @throws Exception
     */
    public function refundSelect($orderId,$number,$refund_reason,$options=[]){
        if((empty($orderId) and empty($number) ) or empty($refund_reason)){
            return false;
        }
        $aop = $this->client();
        $params =[
            'out_trade_no'=>$orderId,
            'trade_no'=>$number,
            'out_request_no'=>$refund_reason
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request = new AlipayTradeFastpayRefundQueryRequest();
        $request->setBizContent( json_encode( $params));
        $result = $aop->execute ( $request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $result->$responseApiName;
    }

    /**
     * 账单下载url
     * @param $bill_date
     * @param string $bill_type
     * @param array $options
     * @return SimpleXMLElement
     * @throws Exception
     */
    public function getBillDownloadUrl($bill_date,$bill_type='trade',$options=[]){
        $aop = $this->client();
        $params =[
            'bill_type'=>$bill_type,
            'bill_date'=>$bill_date
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request = new AlipayDataDataserviceBillDownloadurlQueryRequest();
        $request->setBizContent( json_encode( $params));
        $result = $aop->execute ( $request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $result->$responseApiName;
    }

    /**
     * 异步通知
     * @param $data
     * @return mixed|void
     *
     */
    public function notify($data)
    {
        $this->payEvent->receipt_amount = $data['receipt_amount'];
        $this->payEvent->order_id = $data['out_trade_no'];
        $this->payEvent->trade_no = $data['trade_no'];
        if($data['trade_status']=='TRADE_SUCCESS'){
         $this->payEvent->status =1;
        }
        wp_mail('757402123@qq.com','阿里',print_r( $data,true));
        $this->trigger(PayBehavior::EVENT_BEFORE_NOTIFY);
    }

    /**
     * @param $orderId
     * @param $subject
     * @param $money
     * @param string $notifyUrl
     * @param string $returnUrl
     * @param array $options
     * @return 提交表单HTML文本|构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）|string
     * @throws Exception
     */
    public function submitPc($orderId,$subject,$money,$notifyUrl='',$returnUrl='',$options=[]){

        $aop = $this->client();
        $object =[
            "out_trade_no" => $orderId,
            "total_amount" => $money,
            "subject" => $subject,
            "product_code" =>'FAST_INSTANT_TRADE_PAY',
            "time_expire" => date("Y-m-d H:i:s",time()+15*60),
        ];
        $object =ArrayHelper::merge($object,$options);
        $json = json_encode($object);
        $request = new AlipayTradePagePayRequest();
        $request->setNotifyUrl($notifyUrl);
        $request->setReturnUrl($returnUrl);
        $request->setBizContent($json);
        return $aop->pageExecute( $request);
    }

    /**
     * @param $orderId
     * @param $subject
     * @param $money
     * @param string $notifyUrl
     * @param string $returnUrl
     * @param array $options
     * @return 提交表单HTML文本|构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）|string
     * @throws Exception
     */
    public function submitWap($orderId, $subject, $money, $notifyUrl='', $returnUrl='',  $options=[]){

        $aop = $this->client();
        $object =[
            "out_trade_no" => $orderId,
            "total_amount" => $money,
            "subject" => $subject,
            "product_code" =>'FAST_INSTANT_TRADE_PAY',
            "time_expire" => date("Y-m-d H:i:s",time()+15*60),
        ];
        if(!empty($options)){
            $object =ArrayHelper::merge($object,$options);
        }

        $json = json_encode($object);
        $request = new AlipayTradeWapPayRequest();
        $request->setNotifyUrl($notifyUrl);
        $request->setReturnUrl($returnUrl);
        $request->setBizContent($json);
        return  $aop->pageExecute($request,"GET");
//        return  $aop->execute( $request);
    }

    public function submitPcQr($orderId,$subject,$money,$notifyUrl='',$returnUrl='',$options=[]){

        $aop = $this->client();
        $object =[
            "out_trade_no" => $orderId,
            "total_amount" => $money,
            "subject" => $subject,
            "product_code" =>'FAST_INSTANT_TRADE_PAY',
            "time_expire" => date("Y-m-d H:i:s",time()+15*60),
        ];
        $object =ArrayHelper::merge($object,$options);
        $json = json_encode($object);
        $request = new AlipayTradePagePayRequest();
        $request->setNotifyUrl($notifyUrl);
        $request->setReturnUrl($returnUrl);
        $request->setBizContent($json);
        return $aop->pageExecute( $request);
    }

    /**
     * 验证签名
     * @param $params
     * @param string $encryptType
     * @return bool
     */
    public function checkSign($params,$encryptType=''){
        $aop = $this->client();
        return $aop->rsaCheckV1($params, '',$this->signType);
    }

    /**
     * 转账到支付宝账户 仅在证书模式下有效
     * @param $orderId 转账id 商家自定义保证唯一性
     * @param $orderMoney 转账金额
     * @param $toUser 收款方唯一标识
     * @param $toUserName 收款方名称
     * @param string $orderTitle 转账标题
     * @param string $orderRemark 转账备注信息
     * @param string $identity_type
     * @param array $options 其他参数
     * @return mixed
     * @throws Exception
     */
    public function remit($orderId,$orderMoney,$toUser,$toUserName, $orderTitle="",$orderRemark="", $identity_type='ALIPAY_LOGON_ID',$options=[]){
        $this->pathInit();
        $privateKey = str_replace(PHP_EOL,"", file_get_contents($this->appPrivateKey));
        $alipayConfig = new AlipayConfig();
        $alipayConfig->setPrivateKey($privateKey);
        $alipayConfig->setServerUrl($this->alipayUli);
        $alipayConfig->setAppId($this->appId);
        $alipayConfig->setCharset("utf-8");
        $alipayConfig->setSignType($this->signType);
        $alipayConfig->setEncryptKey("");
        $alipayConfig->setFormat("json");
        $alipayConfig->setAppCertPath($this->appPublicCert);
        $alipayConfig->setAlipayPublicCertPath($this->alipayPublicCert);
        $alipayConfig->setRootCertPath($this->alipayRootCert);
        $alipayClient = new AopCertClient($alipayConfig);
        $alipayClient->isCheckAlipayPublicCert = true;
        $request = new AlipayFundTransUniTransferRequest();
        $params=[
            "out_biz_no"=>$orderId,//转账单号
            "trans_amount"=>$orderMoney,//转账金额
            'product_code'=>"TRANS_ACCOUNT_NO_PWD",//销售产品码。单笔无密转账固定为
            'biz_scene'=>"DIRECT_TRANSFER",//业务场景。单笔无密转账固定为
            'order_title'=>$orderTitle,//转账业务的标题，用于在支付宝用户的账单里显示
            'remark'=>$orderRemark,//转账备注，
            // 收款方信息
            'payee_info'=>[
                //参与方的标识 ID。
                //当 identity_type=ALIPAY_USER_ID 时，填写支付宝用户 UID。示例值：2088123412341234。
                //当 identity_type=ALIPAY_LOGON_ID 时，填写支付宝登录号。示例值：186xxxxxxxx。
                'identity'=>$toUser,
                //参与方的标识类型，目前支持如下枚举：
                //ALIPAY_USER_ID：支付宝会员的用户 ID，可通过 获取会员信息 能力获取。
                //ALIPAY_LOGON_ID：支付宝登录号，支持邮箱和手机号格式。
                'identity_type'=>$identity_type,
                //参与方真实姓名。如果非空，将校验收款支付宝账号姓名一致性。
                //
                //当 identity_type=ALIPAY_LOGON_ID 时，本字段必填。若传入该属性，则在支付宝回单中将会显示这个属性。
                'name'=>$toUserName
            ],
        ];
        if(!empty($options)){
            $params =ArrayHelper::merge($params,$options);
        }
        $request->setBizContent(json_encode($params));
        $responseResult = $alipayClient->execute($request);
        $responseApiName = str_replace(".","_",$request->getApiMethodName())."_response";
        return $responseResult->$responseApiName;
    }
    public static function join($error){
        $errorStr ='';
        foreach ($error as $key =>$value){
            $errorStr .= $key.":".join('.',$value).PHP_EOL;
        }
        return $errorStr;
    }
}