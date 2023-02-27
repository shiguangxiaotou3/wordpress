<?php

/** @var $this yii\web\View */
use crud\modules\wp\models\Icons;
use crud\modules\wp\assets\WpAsset;
use crud\models\Color;
$assets = new WpAsset();
$dir = $assets->publishedUrl();
$alipay = Yii::$app->alipay;

?>
<!-- 首页 -->
<section>
    <span class="background" style="background-image:url('<?=$dir?>/images/sora-sagano-3BMIntVUsjQ-unsplash.jpg')"></span>
    <div class="wrap aligncenter">
        <h1><strong>支付测试</strong></h1>
        <p class="text-intro"><?= $alipay->appName ?>
        </p>
        <?php
        echo $alipay->submit("wap","test_757402123_".time(),"测试","0.01")
        ?>
    </div>
</section>