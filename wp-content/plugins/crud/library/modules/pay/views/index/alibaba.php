<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use Yii;
use crud\Base;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div style="width: 50%">
        <form action="options.php" method="post">
            <?php
            settings_fields("crud_group_alipay");
            do_settings_sections("pay/index/alibaba");
            submit_button();
            ?>
        </form>

    </div>
</div>

