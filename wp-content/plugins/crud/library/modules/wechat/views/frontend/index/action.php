<?php
/** @var $this yii\web\View */
/** @var $title */
/** @var $result */
use crud\widgets\PreCodeWidget;
?>
<div class="warp">
    <div style="width: 100%">
        <h1><?= isset($title)?$title:"" ?> </h1>
    </div>
    <div style="width: 100%">
        <?= PreCodeWidget::widget([
                'language'=>'json',
                'code'=>json_encode(isset($result)?$result:"",JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)
            ]);
        ?>
    </div>
</div>