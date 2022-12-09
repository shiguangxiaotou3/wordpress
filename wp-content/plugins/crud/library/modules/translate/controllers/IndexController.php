<?php


namespace crud\modules\translate\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{


    public $layout = false;

    public function actions(){
        return ['index','google','youdao','baidu'];
    }

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex(){
       return  $this->render("index");
    }

    public function actionGoogle(){
        return  $this->render("google");
    }

    public function actionYoudao(){
        return  $this->render("youdao");
    }

    public function actionBaidu(){
        return  $this->render("baidu");
    }

}