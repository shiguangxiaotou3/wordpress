<?php


namespace crud\modules\wp\controllers;


use yii\web\Controller;

class IndexController extends Controller
{

    public $layout =false;
    public function actions(){
        return ['index'];
    }
    public function actionIndex(){
        return $this->render("index");
    }
}