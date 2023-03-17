<?php

/** @var $this yii\web\View */
use crud\modules\wp\models\Icons;
use crud\modules\wp\assets\WpAsset;
use crud\models\Color;
$assets = new WpAsset();
$dir = $assets->publishedUrl();
$request = Yii::$app->request;
$data =$request->get();
echo json_encode($data);
$alipay = Yii::$app->alipay;
if($alipay-> checkSign($data)){
$message="支付成功";
}else{
    $message="支付失败";
}
?>
<!-- 首页 -->
<section>
    <span class="background" style="background-image:url('<?=$dir?>/images/sora-sagano-3BMIntVUsjQ-unsplash.jpg')"></span>
    <div class="wrap aligncenter">
        <h1><strong><?= $message ?></strong></h1>
        <p class="text-intro"><?= $alipay->appName ?>
        </p>
    </div>
</section>
