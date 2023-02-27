<?php
namespace crud\modules\wechat\controllers\api;

use Yii;
use yii\web\Controller;


class NotifController extends Controller
{

    /**
     *  添加临时通知邮箱
     * @return string
     */
    public function actionIndex(){
        $mail = Yii::$app->request->get("mail");
        if(!empty($mail)){
            preg_match('/(?:[0-9a-zA-Z_]+.)+@[0-9a-zA-Z]{1,13}\.[com,cn,net]{1,3}/',$mail,$res);
            if(isset($res[0]) and  !empty($res[0])){
                $tmp = Yii::$app->cache->get("notif_mail");
                if($tmp){
                    if(!in_array($mail,$tmp)){
                        array_push($tmp,$mail);
                        Yii::$app->cache->set('notif_mail',$tmp,300) ;
                    }else{
                        return '不要重复添加';
                    }
                }else{
                    Yii::$app->cache->set('notif_mail',[$mail],300) ;
                }
                return 'success';
            }else{
                return '格式错误';
            }
        }else{
            return '你谁啊';
        }
    }
}