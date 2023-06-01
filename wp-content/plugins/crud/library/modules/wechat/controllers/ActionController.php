<?php

namespace crud\modules\wechat\controllers;

use Yii;
use yii\web\Controller;

class ActionController extends Controller
{
    public function actionAccessToken(){
        return $this->success('ok',Yii::$app->subscription->getAccessToken());
    }

    public function actionTicket(){
        return $this->success('ok',Yii::$app->subscription->getTicket());
    }
    public function actionCache(){
        return $this->success('ok',Yii::$app->cache->flush());
    }
}