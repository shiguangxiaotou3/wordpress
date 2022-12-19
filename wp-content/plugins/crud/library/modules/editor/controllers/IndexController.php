<?php


namespace crud\modules\editor\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{


    public $layout = false;

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex(){
       return  $this->render("index");
    }

}