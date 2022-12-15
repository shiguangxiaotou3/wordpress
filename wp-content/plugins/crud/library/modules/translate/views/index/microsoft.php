<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_microsoft");
        do_settings_sections("translate/index/microsoft");
        submit_button();
        ?>
    </form>
</div>