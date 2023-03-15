<?php
namespace crud\modules\pay\components;

use Yii;
use Exception;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use shiguangxiaotou\alipay\AopClient;
use shiguangxiaotou\alipay\AlipayConfig;
use shiguangxiaotou\alipay\AopCertClient;
use shiguangxiaotou\alipay\request\AlipayTradeCloseRequest;
use shiguangxiaotou\alipay\request\AlipayTradeQueryRequest;
use shiguangxiaotou\alipay\request\AlipayTradeRefundRequest;
use shiguangxiaotou\alipay\request\AlipayTradeWapPayRequest;
use shiguangxiaotou\alipay\request\AlipayTradePagePayRequest;
use shiguangxiaotou\alipay\request\AlipayFundTransUniTransferRequest;
use shiguangxiaotou\alipay\request\AlipayTradeFastpayRefundQueryRequest;
use shiguangxiaotou\alipay\request\AlipayDataDataserviceBillDownloadurlQueryRequest;

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

    private function client($encryptType=""){
        $this->pathInit();
        if(empty($encryptType)){
            $encryptType = $this->encryptType;
        }
        if($encryptType){
            $client = new AopClient ();
            $client->gatewayUrl =$this->alipayUli;
            $client->appId = $this->appId;
            $client->rsaPrivateKey = str_replace(PHP_EOL,"",file_get_contents($this->appPrivateKey));
            $client->alipayrsaPublicKey =str_replace(PHP_EOL,"",file_get_contents( $this->alipayPublicKey));
            $client->apiVersion = '1.0';
            $client->signType = $this->signType;
            $client->postCharset = 'utf-8';
            $client->format = 'json';
            return  $client;
        }else{
            $aop = new AopCertClient ();
            $aop->gatewayUrl =$this->alipayUli;
            $aop->appId = $this->appId;
            $str = file_get_contents($this->appPrivateKey);
            $aop->rsaPrivateKey = str_replace(PHP_EOL,"",$str);
            $aop->alipayrsaPublicKey = $aop->getPublicKey($this->alipayPublicCert);
            $aop->apiVersion = '1.0';
            $aop->signType = $this->signType;
            $aop->postCharset = 'utf-8';
            $aop->format = 'json';
            $aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
            $aop->appCertSN = $aop->getCertSN($this->appPublicCert);//调用getCertSN获取证书序列号
            $aop->alipayRootCertSN = $aop->getRootCertSN($this->alipayRootCert);//调用getRootCertSN获取支付宝根证书序列号
            return  $aop;
        }
    }

    public function test(){
//        $resultCode = $result->$responseNode->code;
//        if(!empty($resultCode)&&$resultCode == 10000){
//            echo "成功";
//        } else {
//            echo "失败";
//        }

    }

    /**
     * @param 订单场景 $palType
     * @param 订单号|string $orderId
     * @param 订单标题|string $subject
     * @param 订单金额|number $money
     * @param string $notifyUrl
     * @param string $returnUrl
     * @param array $options
     * @return 提交表单HTML文本|构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）|mixed|string
     */
    public function submit( $palType , $orderId, $subject, $money, $notifyUrl='', $returnUrl='', $options=[])
    {
        if($palType=="pc"){
            return  $this->submitPc($orderId,$subject,$money,$notifyUrl,$returnUrl,$options);
        }elseif ($palType =="wap"){
            return  $this->submitWap($orderId,$subject,$money,$notifyUrl,$returnUrl,$options);
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
     * @return false
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
     * @return false
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
     * @return mixed|void
     *
     */
    public function notify()
    {
    }

    /**
     * @param $orderId
     * @param $subject
     * @param $money
     * @param string $notifyUrl
     * @param string $returnUrl
     * @param array $options
     * @return 提交表单HTML文本|构建好的、签名后的最终跳转URL（GET）或String形式的form（POST）|string
     */
    public function submitPc($orderId,$subject,$money,$notifyUrl='',$returnUrl='',$options=[]){
        $notifyUrl = empty($notifyUrl) ? $this->notifyUrl : $notifyUrl;
        $returnUrl = empty($returnUrl) ? $this->returnUrl : $returnUrl;
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
     */
    public function submitWap($orderId, $subject, $money, $notifyUrl='', $returnUrl='',  $options=[]){
        $notifyUrl = empty($notifyUrl) ? $this->notifyUrl : $notifyUrl;
        $returnUrl = empty($returnUrl) ? $this->returnUrl : $returnUrl;
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
        return $aop->pageExecute( $request);
    }

    public function submitPcQr($orderId,$subject,$money,$notifyUrl='',$returnUrl='',$options=[]){
        $notifyUrl = empty($notifyUrl) ? $this->notifyUrl : $notifyUrl;
        $returnUrl = empty($returnUrl) ? $this->returnUrl : $returnUrl;
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
        $aop = $this->client($encryptType);
        return $aop->rsaCheckV1($params, $this->appPublicKey,$this->signType);
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
//        if(!empty($response->code)&&$response->code==10000){
//            echo("调用成功");
//        }
//        else{
//            echo("调用失败");
//        }
    }
}