<?php
namespace crud\modules\wechat\controllers;

use Yii;
use yii\web\Controller;

class AccessTokenController extends Controller{

    public $layout =false;
    public function actionIndex(){
        $wechat=  Yii::$app->wechat;
        return $wechat->getAccessToken();
    }
    public function actionCreate(){}
    public function actionUpdate($id){}
    public function actionDelete($id){}
    public function actionView($id){}
    public function actionOptions(){}
}