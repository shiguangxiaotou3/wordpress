<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>


    <form action="options.php" method="post">
        <?php
                settings_fields("crud_group_google");
                do_settings_sections("translate/index/google");
                submit_button();
        ?>
    </form>
    <hr style="width: 100%;" />



</div>