<?php

use  yii\helpers\Html;
use crud\modules\wp\assets\WebSlidesAsset;
use crud\modules\wp\assets\WpAsset;
/** @var $this yii\web\View */
/** @var $content string */

WebSlidesAsset::register($this);
WpAsset::register($this);
$wpAsset = (new WpAsset())->publishedUrl();
$this->registerCss(".logo a{background:url('".$wpAsset."/images/logo.jpeg')}");
?>

<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="theme-color" content="#333333">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <header role="banner">
        <nav role="navigation">
            <p class="logo"><a href="/" title="<?= Yii::$app->name ?>">home</a></p>
            <ul>
                <li><?= Html::a('首页','/crud/') ?></li>
                <li><?= Html::a('文档','/crud/index/docs/') ?></li>
                <li><?= Html::a('Api','/crud/index/api/') ?></li>
                <li><?= Html::a('关于','/crud/index/about/') ?></li>
                <li><?= Html::a('Icons','/crud/index/icons/') ?></li>
                <li><?= Html::a('返回主页','/') ?></li>
            </ul>
        </nav>
    </header>
    <main role="main">
        <article id="webslides" class="vertical">
            <?= $content ?>
        </article>
    </main>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>