<?php


namespace crud\modules\pay\components;

use Yii;
use \Shiguangxiaotou\Alipay\AopClient;
use \Shiguangxiaotou\Alipay\AopCertClient;
use \Shiguangxiaotou\Alipay\Request\AlipayTradePagePayRequest;
use yii\base\Component;

defined("ALIPAY_DIR") or define("ALIPAY_DIR" ,dirname( __DIR__));
class Alipay extends Component implements Pay
{
    // +----------------------------------------------------------------------
    // ｜支付场景
    // +----------------------------------------------------------------------
    // ｜当面付 PayInPerson
    // ｜小程序支付'AppletPayment
    // ｜电脑网站支付 'ComputerWebsitePayment'
    // ｜APP支付AppPayment
    // ｜手机网站支付 MobileSitePayment
    // ｜转账到支付宝账户 TransferToAlipayAccount
    // +----------------------------------------------------------------------

    const PAY_IN_PERSON='PayInPerson';
    const APPLET_PAYMENT='AppletPayment';
    const COMPUTER_WEBSITE_PAYMENT='ComputerWebsitePayment';
    const APP_PAYMENT='AppPayment';
    const MOBILE_SITE_PAYMENT='MobileSitePayment';
    const TRANSFER_TO_ALIPAY_ACCOUNT='TransferToAlipayAccount';

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

    public function init(){
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
            if (!empty($this->$value) and substr($value,0,1) =="@" ){
                $this->$value = Yii::getAlias($value);
            }
        }
    }

    private function client($encryptType=""){
        if(empty($encryptType)){
            $encryptType = $this->encryptType;
        }
        if(!$encryptType){
            //公钥模式
            $client = new AopClient ();
            $client->appId = $this->appId;
            $client->rsaPrivateKey = $this->appPrivateKey;
            $client->alipayrsaPublicKey = $this->alipayPublicKey;
            $client->apiVersion = '1.0';
            $client->signType = $this->signType;
            $client->postCharset = 'utf-8';
            $client->format = 'json';
            return  $client;
        }else{
            // 证书模式
            $aop = new AopCertClient ();
            $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
            $aop->appId = $this->appId;
            $aop->rsaPrivateKey = $this->appPrivateKey;
            $aop->alipayrsaPublicKey = $aop->getPublicKey($this->alipayPublicCert);
            $aop->apiVersion = '1.0';
            $aop->signType = $this->signType;
            $aop->postCharset = 'utf-8';
            $aop->format = 'json';
            $aop->isCheckAlipayPublicCert = true;//是否校验自动下载的支付宝公钥证书，如果开启校验要保证支付宝根证书在有效期内
            $aop->appCertSN = $aop->getCertSN($this->appPublicCert);//调用getCertSN获取证书序列号
            $aop->alipayRootCertSN = $aop->getRootCertSN($this->alipayRootCert);//调用getRootCertSN获取支付宝根证书序列号
            return $aop;
        }
    }

    public function test(){
        $aop = $this->client();
//        $object = new stdClass();
        $object =[
           "out_trade_no" => '20210817010101004',
        "total_amount" => 0.01,
        "subject" => '测试商品',
        "product_code" =>'FAST_INSTANT_TRADE_PAY',
        "time_expire" => date("Y-m-d H:i:s"),
        ];
//        $object->out_trade_no = '20210817010101004';
//        $object->total_amount = 0.01;
//        $object->subject = '测试商品';
//        $object->product_code ='FAST_INSTANT_TRADE_PAY';
//        $object->time_expire = date("Y-m-d H:i:s");

        $json = json_encode($object);
        $request = new \Shiguangxiaotou\Alipay\Request\AlipayTradePagePayRequest();
        $request->setNotifyUrl('');
        $request->setReturnUrl('');
        $request->setBizContent($json);
        $result = $aop->pageExecute ( $request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }

    }


    public function risk()
    {

    }

    public function submit()
    {

    }

    public function select()
    {

    }

    public function close()
    {

    }

    public function reverse()
    {

    }

    public function refund()
    {

    }

    public function notify()
    {
    }
}