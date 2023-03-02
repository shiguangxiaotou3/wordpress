<?php


namespace crud\modules\market\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * 首页
     *
     * @return false|string
     */
    public function actionIndex(){

        return  $this->render("index");
    }

    public function actionSettings(){
        return  $this->render("settings");
    }

}