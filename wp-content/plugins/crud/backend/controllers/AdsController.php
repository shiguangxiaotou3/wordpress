<?php


namespace backend\controllers;

use crud\library\components\Ads;
use crud\library\components\Flows;
use Yii;
use yii\web\Controller;

class AdsController extends Controller{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index","redirect-uri","flows","doc"
        ];
    }

    public function actionIndex(){
        session_start();
        $ads = Yii::$app->ads;
        $token=[] ;
        $code ="";
        // 第一次获取token
        if(isset($_SESSION["code"])){
            $code =$_SESSION["code"];
            $token = $this->getToken();
            $token['code']=$code;
        }
        // 非第一次 过去刷新令牌
        if(empty($token)){
            $token["RefreshToken"]= file_get_contents(Yii::getAlias($ads->oAuthRefreshTokenPath));
        }
        return $this->render("index",[
            "url"=> $ads->getTokenUrlByCli(),
            "token"=>$token,
            "code"=>$code
        ]);
    }

    public function actionDoc(){
        $myText="";
        $mdPath= Yii::getAlias("@backend/views/ads/ads.md");
        if(file_exists($mdPath)){
            $myText = file_get_contents($mdPath);
        }
        return $this->render("doc",[
            "myText"=>$myText
        ]);
    }

    public function actionRedirectUri(){
        return $this->render("redirect_uri");
    }

    public function actionFlows(){
        $results =[];
        $methods = get_class_methods(Flows::className());
        foreach ($methods as $method){
            $results[$method] = getMethodArgs(Flows::className(),$method);
        }

        return $this->render("flows",["results"=>$results]);
    }

    private function getToken(){
        $code = $_SESSION["code"];
        unset($_SESSION["code"]);
        $ads = Yii::$app->ads;
        $res = $ads->authorizationData->Authentication->RequestOAuthTokensByResponseUri("https://www.shiguangxiaotou.com/?code=".$code);
        $ads->WriteOAuthRefreshToken($ads->authorizationData->Authentication->OAuthTokens->RefreshToken);
        session_destroy();
        return get_object_vars($res);
    }
}