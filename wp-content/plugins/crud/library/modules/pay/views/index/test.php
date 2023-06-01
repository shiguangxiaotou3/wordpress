<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use crud\models\wp\WpUsers;
use crud\modules\pay\models\Order;
use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div >
        <?php

            echo date("Y-m-d H:i:s",time() + 15 *60);
//            $alipay = Yii::$app->alipay;
//            $res=  $alipay->submit('aliPayPc',1,"test_remit" . time(),'测试','0.01');
//            echo $res;
            ?>

    </div>
</div>
