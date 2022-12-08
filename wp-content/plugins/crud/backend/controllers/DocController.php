<?php


namespace backend\controllers;


use yii\web\Controller;

class DocController  extends Controller{


    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render("index");
    }

    public function actionIcons(){

        return $this->render('icons');

    }
}