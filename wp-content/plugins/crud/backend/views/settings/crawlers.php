<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\assets\HighlightAsset;
use crud\widgets\PageHeaderWidget;

$options =[
    'controllerOptions'=>[
        "filter" =>function($action){return SettingsSwitch::getSwitch($action);}
    ]
];
HighlightAsset::register($this)->registerAssetFiles($this);

?>


<div class="wrap">
    <?= PageHeaderWidget::widget($options) ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_crawlers");
        do_settings_sections("settings/crawlers");
        submit_button();
        ?>
    </form>
</div>