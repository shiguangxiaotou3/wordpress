<?php


namespace crud\modules\alipay\components;

use yii\base\BaseObject;
use Shiguangxiaotou\Alipay\AopClient;
use Shiguangxiaotou\Alipay\AlipayConfig;
use Shiguangxiaotou\Alipay\AopCertClient;
use Shiguangxiaotou\Alipay\Request\AlipayTradePrecreateRequest;






defined("ALIPAY_DIR") or define("ALIPAY_DIR" ,dirname( __DIR__));
class Alipay extends BaseObject
{
    // appID
    public $appId;
    // 应用名称
    public $appName;
    // 绑定的商家账号(PID)
    public $pid;
    // 接口加密方式
    public $encryptType=true;
    //支付宝网关url
    public $alipayUli='https://openapi.alipaydev.com/gateway.do';
    //支付网关
    public $gateway;
    // 接口内容加密方式
    public $contentEncryptType;
    // 接口内容加解密密钥
    public $contentSecretKey;
    // 授权回调url
    public $authorizationCallbackUil;

    /************ 公钥模式 **************/
    // 支付宝公钥
    public $alipayPublicKey= '/runtime/key/alipayPublicKey_RSA2.txt';
    // app公钥
    public $appPublicKey='/runtime/key/appPublicKey_RSA2048.txt';
    // app私钥
    public $appPrivateKey='/runtime/key/appPrivateKey_RSA2048.txt';

    /************ 证书模式 **************/
    // app公钥证书
    public $appPublicCert='/runtime/certificate/appPublicCert.crt';
    // app证书私钥
    public $appPrivateCertKey ="/runtime/certificate/appPublicCertKey.txt";
    // 支付宝公钥证书
    public $alipayPublicCert="/runtime/certificate/alipayPublicCert.crt";
    //支付宝根证书
    public $alipayRootCert="/runtime/certificate/alipayRootCert.crt";

    public function test(){
        $url = "https://openapi.alipaydev.com/gateway.do";
        $app_id=$this->appId;
        $privateKey=file_get_contents(ALIPAY_DIR."/runtime".$this->appPrivateKey);
        $publicKey =file_get_contents( ALIPAY_DIR."/runtime".$this->appPublicKey);

        $config = new AlipayConfig();
        $config->setAppId($app_id);
        $config->setCharset("utf-8");
        $config->setFormat("json");
        $config->setSignType("RSA2");
        $config->setServerUrl($url);
        $config->setPrivateKey($privateKey);
        $config->setAlipayPublicKey($publicKey);


        $aop = new AopClient($config);

        $parameter = "{" .
            "\"out_trade_no\":\"20140320010107002\"," .
            "\"total_amount\":\"12225\"," .
            "\"subject\":\"Iphone6 65G\"," .
            "\"store_id\":\"CD_001\"," .
            "\"timeout_express\":\"100m\"}";
        $request = new AlipayTradePrecreateRequest ();
        $request->setBizContent($parameter);
        $response = $aop->execute($request);
        $responseApiName = str_replace(".", "_", $request->getApiMethodName()) . "_response";
// 拿到结果
        $responseResult = $response->$responseApiName;
        echo var_dump($responseResult),PHP_EOL;

    }
}