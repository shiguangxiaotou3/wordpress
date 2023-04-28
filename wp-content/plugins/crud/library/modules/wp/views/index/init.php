<?php
use crud\widgets\RegisterHighlightAssetWidget;
/** @var $this yii\web\View */
/** @var $this yii\web\View */
/** @var $wechat crud\modules\wechat\components\SubscriptionService */

$wechat = Yii::$app->subscription;
RegisterHighlightAssetWidget::widget();
$wechat->share();
