<?php
/** @var $this yii\web\View */


use crud\models\SettingsSwitch;
use crud\widgets\PageHeaderWidget;
?>

<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_mail");
        do_settings_sections("base/index/mail");
        submit_button();
        ?>
    </form>

</div>








