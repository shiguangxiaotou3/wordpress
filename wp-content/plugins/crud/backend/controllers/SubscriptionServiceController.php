<?php


namespace backend\controllers;


use yii\web\Controller;

/**
 * 微信公众号平台
 * @package crud\backend\controllers
 */
class SubscriptionServiceController  extends Controller{

    public $enableCsrfValidation=false;
    public $layout=false;

    public function actions(){
        return [
            "index"
        ];
    }

    public function actionIndex(){
        return $this->render("index");
    }
}