<?php
/** @var $this yii\web\View */
use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
            settings_fields("crud_group");
            do_settings_sections("index/settings");
            submit_button();
        ?>
    </form>
</div>


