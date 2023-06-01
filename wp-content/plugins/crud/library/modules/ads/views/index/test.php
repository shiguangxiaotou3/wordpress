<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $results */

use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <?= PreCodeWidget::widget(['code' =>print_r($results,true)  ,"language" => "text"]); ?>
</div>