<?php


namespace backend\controllers;


use yii\web\Controller;

class EditorController  extends Controller
{
    public $layout=false;
    public $enableCsrfValidation=false;

    public function actionIndex(){
        return $this->render('index');
    }
}