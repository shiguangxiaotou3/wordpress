<?php
namespace crud\modules\sms\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use crud\controllers\ApiController;
class IndexController extends ApiController
{
    public $layout=false;

    public $url ="https://api.sms-activate.org/stubs/handler_api.php";

    public function actionIndex(){
       return  $this->render("index");
    }
    public function actionTest(){
        return  $this->render("test");
    }

    public function actionSelect(){
        wp_mail(['757402123@qq.com'],'异步通知测试',print_r($_COOKIE,true));
        if(Yii::$app->request->isAjax){
            $data = Yii::$app->request->post();
            $data['action']=$data['crud'];
            unset($data['crud']);
            wp_mail(['757402123@qq.com'],'异步通知测试',print_r($data,true));
            return $this->success("ok", json_decode($this->httpGet($data),true));
        }
        return $this->error("error");
    }

    public function httpGet($data){
        $url ="https://api.sms-activate.org/stubs/handler_api.php";
        $data= ArrayHelper::merge([
            "api_key"=>get_option("crud_group_sms_apiKey")],$data);
        return httpGet($url,$data);
    }

    public function httpPost($data){
        $url ="https://api.sms-activate.org/stubs/handler_api.php";
        $data= ArrayHelper::merge([
            "api_key"=>get_option("crud_group_sms_apiKey")],$data);
        return httpPost($url,$data);

    }
}