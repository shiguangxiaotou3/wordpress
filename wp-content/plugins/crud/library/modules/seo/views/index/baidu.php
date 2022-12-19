<?php
/** @var $this yii\web\View */

use yii\helpers\Html;
use crud\widgets\PageHeaderWidget;

?>

<div class="wrap">
    <?= PageHeaderWidget::widget([
        'buttons' => [Html::button('测试',['id'=>'test',"class"=>"button button-success"])]
    ]) ?>

    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_seo_baidu");
        do_settings_sections("seo/index/baidu");
        submit_button();
        ?>
    </form>
</div>
