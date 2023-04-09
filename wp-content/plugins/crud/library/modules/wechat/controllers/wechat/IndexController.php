<?php


namespace crud\modules\wechat\controllers\wechat;


use yii\web\Controller;

class IndexController extends Controller
{
    public $layout ='wechat';

    public function actionIndex(){
        return $this->render('index');
    }

    public function actionTest(){
        return $this->render('test');
    }
}