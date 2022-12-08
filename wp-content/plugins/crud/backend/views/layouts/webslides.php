<?php

use  yii\helpers\Html;
use common\widgets\Seo;
use ShiGuangXiaoTou\assets\WebSlidesAsset;

/** @var $this yii\web\View */
/** @var $content string */
WebSlidesAsset::register($this);

Seo::widget();
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
            <p class="logo"><a href="/" title="WebSlides">home</a></p>
            <?php
                $menu = Yii::$app->params['menu'];
                $html="";
                foreach ($menu as $item){
                    $item['options']['rel']="external";
                    $item['options']['title']=$item['label'];
                    $a=Html::a($item['label'],$item['url'],$item['options']);
                    $html.=<<<HTML
                    <li class="twitter">
                        {$a}
                    </li>
HTML;
                }
            ?>
            <ul>
                <?=  $html ?>
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