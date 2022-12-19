<?php
/** @var $this yii\web\View */
/** @var $data string */

use crud\widgets\WpTableWidget;
use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <?= WpTableWidget::widget([
            'data' => $data,
            "columns" => [
                ["field" => "action", "title" => "名称"],
                ["field" => "description", "title" => "描述","callback"=>function($row){ return Yii::t("ads",$row['description']);}],
                ["field" => "request_Limits", "title" => "限制","callback"=>function($row){ return Yii::t("ads",$row['request_Limits']);}],
            ]
        ]);
    ?>

</div>
