<?php


namespace api\controllers;
use yii\web\Controller;
use Yii;
class IndexController extends Controller{


    public function actionIndex(){
        $request = Yii::$app->request;
        logObject($request->get());
        logObject($request->post());
        return "asdas";
    }


    public function actionTest($id){
        echo $id;
    }
}