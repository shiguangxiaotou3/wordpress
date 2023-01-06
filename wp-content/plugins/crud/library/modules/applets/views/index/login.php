<?php
/** @var $this yii\web\View */

/** @var $data array|null */
use crud\widgets\PageHeaderWidget;
?>

    <div class="wrap">
        <?= PageHeaderWidget::widget() ?>
        <?php dump($data); ?>
    </div>
<?php

