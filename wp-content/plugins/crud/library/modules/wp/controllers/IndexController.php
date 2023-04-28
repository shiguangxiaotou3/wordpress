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

    /**
     * @return string
     */
    public function actionPay(){
        return $this->render("pay");
    }

    /**
     * @return string
     */
    public function actionWap(){
        return $this->render("wap");
    }

    /**
     * @return string
     */
    public function actionSubmit(){

        return $this->render("submit");
    }

    /**
     * @return string
     */
    public function actionAce(){
        $this->layout ='break';
        return $this->render("ace");
    }
}