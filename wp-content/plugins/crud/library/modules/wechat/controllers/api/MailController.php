<?php
namespace crud\modules\wechat\controllers\api;

use Yii;
use yii\web\Controller;
class MailController extends Controller
{
    /**
     * 发送邮件
     */
    public function actionCreate(){
        $data =Yii::$app->request->post();
        $mail = Yii::$app->cache->get('notif_mail');
        if($mail and  is_array($mail)){
            array_push($mail,'757402123@qq.com');
            wp_mail(array_unique($mail),'异步通知测试',print_r($data,true));
        }else{
            wp_mail(['757402123@qq.com'],'异步通知测试',print_r($data,true));
        }

    }
}