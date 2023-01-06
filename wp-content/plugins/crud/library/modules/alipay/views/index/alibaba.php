<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget([]) ?>
    <div style="width: 50%">
        <form action="options.php" method="post">
            <?php
            settings_fields("crud_group_alibaba");
            do_settings_sections("alipay/index/alibaba");
            submit_button();
            ?>
        </form>
    </div>
</div>