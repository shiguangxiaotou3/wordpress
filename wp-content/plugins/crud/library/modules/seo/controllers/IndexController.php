<?php


namespace crud\modules\seo\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{


    public $layout = false;

    public function actions(){
        return ['index','baidu'];
    }

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex(){
       return  $this->render("index");
    }

    public function actionBaidu(){
        return  $this->render("baidu");
    }

}