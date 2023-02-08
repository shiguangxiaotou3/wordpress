<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <h3><?= $name ?></h3>

    <p><?= nl2br(Html::encode($message)) ?></p>

    <p>
        Web服务器处理您的请求时发生上述错误.
        如果您认为这是服务器错误，请与我们联系. 谢谢!
        同时,您可以返回<a href='<?= Yii::$app->homeUrl ?>'>仪表板</a>或尝试使用搜索类型

    </p>
</div>
