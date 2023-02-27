<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use crud\Base;
use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div >
        <?php
        $alipay = Yii::$app->alipay;
//        echo $alipay->appId;
//        $var = $alipay->getBillDownloadUrl("2023-01");
//        var_dump($var);
        echo $alipay->submit("pc","test_757402123_".time(),"测试","0.1")
        ?>
    </div>
</div>