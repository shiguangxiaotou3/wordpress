<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\assets\HighlightAsset;
use crud\widgets\PageHeaderWidget;
use crud\widgets\RegisterHighlightAssetWidget;
RegisterHighlightAssetWidget::widget();
HighlightAsset::register($this)->registerAssetFiles($this);

?>

<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_crawlers");
        do_settings_sections("base/index/crawlers");
        submit_button();
        ?>
    </form>
</div>