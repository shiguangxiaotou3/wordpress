<?php


namespace crud\modules\wechat\controllers\api;


use yii\web\Controller;
use Yii;
class MailController extends Controller
{
    public function actionCreate(){
        $data =Yii::$app->request->post();
        wp_mail(['757402123@qq.com'],'异步通知测试',print_r($data,true));
    }
}