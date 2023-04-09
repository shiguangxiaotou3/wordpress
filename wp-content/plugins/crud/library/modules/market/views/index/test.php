<?php
/** @var $this yii\web\View */

use crud\models\wp\WpUserMeta;
use \crud\models\wp\WpUsers;
use yii\web\View;
use crud\widgets\PageHeaderWidget;

?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
        asdas
    <?php

//    $result = WpUserMeta::find()
//        ->where(['meta_key'=>'phone'])
//        ->andWhere(['meta_value'=>'17762482477'])->one();
////    self::find()->where(['ID'=>$result->user_id])->one();
//   $data = WpUsers::find()->where(['ID'=>1])->one();
    dump( WpUsers::getUserByPhone('17762482477'));
//    $tencent = Yii::$app->tencent;
//    dump($tencent->applet->getAccessToken());
        Yii::$app->cache->flush();
//    $cache = Yii::$app->cache;
//    $access_token = $cache->get("market_applet_access_token");
//    var_dump($access_token);
//    $tencent = Yii::$app->tencent;
//    $code = Yii::$app->request->get('code','');
//    $phone =$tencent->applet->getPhone($code);
//    $url ='https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=ACCESS_TOKEN';
//   $res = httpPost($url,['code'=>'','access_token'=>$tencent->applet->accessToken]);
//    dump($tencent->applet->accessToken);


    ?>
</div>