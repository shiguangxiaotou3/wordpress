<?php


namespace backend\controllers;


use yii\web\Controller;

class WpController extends Controller
{
    public $enableCsrfValidation=false;
    public $layout=false;

    public function actionIndex(){
        return $this->render('index');
    }
}