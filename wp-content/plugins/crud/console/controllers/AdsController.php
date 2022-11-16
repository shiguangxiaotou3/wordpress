<?php


namespace console\controllers;


use Yii;
use yii\console\Controller;
use crud\library\components\Ads;

/**
 * Bing  Ads广告组件
 * @package crud\console\controllers
 */
class AdsController extends Controller{

    /**
     * 通过CLI获取Ads的token授权url
     */
    public function actionIndex(){
        $ipinfo['region'] ="Hubei";
        /** @var Ads $ads */
        $ads = Yii::$app->ads;
        upDateConfig(
            Yii::getAlias("@library/messages/region/zh-CN/region.php"),
            [$ipinfo['region']=>""]
        );
//       echo $ads->getTokenUrlByCli();
    }

    /**
     * 生产uuid
     * @throws \yii\db\Exception
     */
    public function actionUuid(){
        $row= Yii::$app->db->createCommand("select uuid() as uuid")->queryOne();
        echo $row["uuid"];
    }
}