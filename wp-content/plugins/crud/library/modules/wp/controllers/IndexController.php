<?php


namespace crud\modules\wp\controllers;


use yii\web\Controller;

class IndexController extends Controller
{
    public $layout ='webslides';
    public function actions(){
        return ['index'];
    }
    public function actionIndex(){
        $this->layout =false;
        return $this->render("index");
    }
    public function actionTest(){
        return $this->render("test");
    }
}