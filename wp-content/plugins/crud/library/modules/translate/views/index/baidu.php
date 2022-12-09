<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_baidu");
        do_settings_sections("translate/index/baidu");
        submit_button();
        ?>
    </form>
</div>