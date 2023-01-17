<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<nav class="nav">
    <div class="nav-item">
        <a href="/">首页</a>
        <a href="/crud/">wp模块</a>
    </div>
</nav>
<?= $content ?>
<div class="footer">
    <div >
        <p>Posted by: <a href="https://github.com/shiguangxiaotou3" target="_blank"><i>ShiGuangXiaoTou</i></a></p>
        <span style="float: right"><?= date("Y-m-d") ?></span>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

