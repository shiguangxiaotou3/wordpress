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
        return $this->render("init");
    }

    /**
     * @return string
     */
    public function actionError(){
        return $this->render("error");
    }

    /**
     * @return string
     */
    public function actionDocs(){
        return $this->render("docs");
    }

    public function actionIcons(){
        return $this->render("icons");
    }
}