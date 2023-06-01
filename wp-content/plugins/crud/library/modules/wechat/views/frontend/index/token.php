<?php
/** @var $this yii\web\View */
/** @var $wechat crud\modules\wechat\components\SubscriptionService */

$wechat = Yii::$app->subscription;

?>
<div class="warp">
    <div style="width: 100%">
        <h1></h1>
    </div>
    <div style="width: 100%">
        <pre><code><?= $wechat->accessToken ?></code></pre>
    </div>
</div>

