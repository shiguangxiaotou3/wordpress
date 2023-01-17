<?php
/** @var $this yii\web\View */

use yii\web\View;
use crud\models\SettingsSwitch;
use crud\widgets\WpTableWidget;
use crud\widgets\PageHeaderWidget;

$options =[
    'controllerOptions'=>[
        "filter" =>function($action){return SettingsSwitch::getSwitch($action);}
    ]
];
?>


<div class="wrap">
    <?= PageHeaderWidget::widget($options) ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_dns");
        do_settings_sections("base/index/dns");
        submit_button();
        ?>
    </form>
    <?php


    try {
        $domains = Yii::$app->dns->domains;
        if( $domains){
            echo WpTableWidget::widget([
                'columns' => [
                    ["field" => "domainName", "title" => '名称'],
                    ["field" => "createTime", "title" => '创建时间'],
                    ["field" => "recordCount", "title" => '解析记录数'],
                    ["field" => "remark", "title" => '备注']
                ],
                "data" => $domains
            ]);
        }
    }catch (Exception $exception){

    }


    ?>
</div>


