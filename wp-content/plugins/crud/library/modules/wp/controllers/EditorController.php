<?php
namespace crud\modules\wp\controllers;

use yii\web\Controller;





class EditorController extends Controller{


    public $layout ='main' ;
    public function actionIndex(){
        return $this->render("index");
    }
}