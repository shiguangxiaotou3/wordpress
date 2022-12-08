<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\assets\HighlightAsset;
use crud\assets\JvectormapAsset;

use crud\widgets\ControllerActionsWidget;
use crud\library\widgets\JvectormapVisitorsWidget;
use crud\library\widgets\JvectormapMarkersWidget;

$crawlers = Yii::$app->crawlers;
//JvectormapAsset::addJsFile($this,"/maps/city/world/world-merc.js",["depends"=>"yii\web\JqueryAsset"]);
////JvectormapAsset::addJsFile($this,"/maps/city/world/world-merc_language/en.json");
//JvectormapAsset::addJsFile($this,"/maps/region/cn/cn_merc.js",["depends"=>"yii\web\JqueryAsset"]);
//JvectormapAsset::addJsFile($this,"/maps/region/cn/cn_merc_language/zh.json");
?>


    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?=  get_admin_page_parent() ?>
            <small><?php echo esc_html( get_admin_page_title() ); ?></small>
        </h1>
        <hr class="wp-header-end" />
        <?php settings_errors(); ?>
        <?= ControllerActionsWidget::widget(["filter" =>function($action){return SettingsSwitch::getSwitch($action);}]); ?>
        <form class="search-form search-plugins" method="get">
            <p class="search-box">
                <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
                <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
                <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
            </p>
        </form>
        <hr style="width: 100%;" />

        <form action="options.php" method="post">
            <?php
            settings_fields("crud_group_jvectormap");
            do_settings_sections("settings/jvectormap");
            submit_button();
            ?>
        </form>
        <div class="map" style="">
            <?php
            echo JvectormapVisitorsWidget::widget([
                "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
                "options" => ["id" => 'world_visitors', "class" => "map_item"],
                "visitorsData" => $crawlers->JvectormapVisitors(7)
            ]);
            echo JvectormapMarkersWidget::widget([
                "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
                "options" => ["id" => 'world_markers', "class" => "map_item"],
                "markersData" => $crawlers->JvectormapMarkers(7),
            ]);

            echo JvectormapMarkersWidget::widget([
                "jvectormapOptions" => ["backgroundColor" => '#1d1f21'],
                "options" => ["id" => 'cn_markers', "class" => "map_item"],
                "mapFile" => "/maps/region/cn/cn_merc.js",
                "mapName" => "cn_merc",
                "markersData" => $crawlers->JvectormapMarkers(7, "CN"),
            ]);
             ?>
        </div>
    </div>
<?php

$css = <<<CSS
 .map{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}
.map_item{
    margin: 10px auto;
    width: 480px ;height:270px;
     /*width: 960px ;height:540px;*/
    background-color: rgb(220,220,220);
}
.test{
    background-color: #00a65a;
    background-color: #111;
    background-color:#92c1dc;
    background-color: #ebf4f9;
    background-color: red;
    background-color: red;
    background-color: red;
    background-color: red;
}
CSS;
$this->registerCss($css);
$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle){
    $this->registerAssetFiles($name);
}
//1080 1920