<?php


namespace crud\common\controllers;


use Yii;
use yii\web\Controller;

class TableController  extends Controller{

    /**
     * @var $modelClass
     */
    public $modelClass;

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id){
        return $this->render('view');
    }

    /**
     * @param $id
     * @return string
     */
    public function actionEdit($id){
        return $this->render('');
    }

    /**
     * @return string
     */
    public function actionDelete($id){
        return $this->render('index');
    }

    /**
     *
     */
    private function getModel(){
        return Yii::createObject(["class"=>$this->modelClass]);

    }
}