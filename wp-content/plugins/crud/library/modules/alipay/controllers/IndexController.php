<?php


namespace crud\modules\alipay\controllers;

use Yii;
use yii\web\Controller;
use crud\modules\ads\components\Ads;
use crud\modules\ads\components\Flows;





class IndexController extends Controller
{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index",'alibaba'
        ];
    }

    public function actionIndex(){
        return $this->render("index");
    }

    public function actionAlibaba(){
        return $this->render('alibaba');
    }

}