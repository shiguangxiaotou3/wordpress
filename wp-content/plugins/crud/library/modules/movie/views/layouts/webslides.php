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
    <html lang="<?= Yii::$app->language ?>" prefix="og: https://www.shiguangxiaotou.com">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li><?= Html::a('首页','/movie') ?></li>
                <li><?= Html::a('最新','/movie/index/trends') ?></li>
                <li><?= Html::a('分类','/movie/index/category') ?></li>
                <li><?= Html::a('关于','/movie/index/search') ?></li>
                <li><?= Html::a('博客','/') ?></li>
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