<?php
/** @var $this yii\web\View */



use crud\widgets\PageHeaderWidget;
?>

<div class="wrap">
    <?= PageHeaderWidget::widget() ?>

    <?php
       dump(Yii::getAlias('@wechat'))
    ?>
</div>