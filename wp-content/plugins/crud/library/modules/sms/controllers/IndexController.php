<?php
namespace crud\modules\sms\controllers;

use Yii;
use yii\web\Controller;


class IndexController extends Controller
{
    public $layout=false;

    public function actionIndex(){

       return  $this->render("index");
    }

    public function actionTest(){
        $request = Yii::$app->request;
        if($request->isAjax){
//            header("Content-Type:application/json;charset=UTF-8;");
            return json_encode([['code'=>"asda","img"=>"asda","name"=>"asda"],['code'=>"asda","img"=>"asda","name"=>"asda"]]);
        }
        return  $this->render("test");
    }

}