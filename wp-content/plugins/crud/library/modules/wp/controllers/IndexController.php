<?php


namespace crud\modules\wp\controllers;

use yii\web\Controller;





class IndexController extends Controller
{
    public $layout ='webslides';

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render("index");
    }

    /**
     * @return string
     */
    public function actionTest(){
        return $this->render("test");
    }

    /**
     * @return string
     */
    public function actionInit(){
        $this->layout =false;
        logObject("执行了");
        return $this->render("init");
    }
}