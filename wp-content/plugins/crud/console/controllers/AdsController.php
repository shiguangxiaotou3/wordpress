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
        var_dump(Yii::$app->flows);
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