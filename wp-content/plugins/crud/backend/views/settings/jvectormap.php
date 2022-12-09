<?php
/** @var $this yii\web\View */

use crud\models\SettingsSwitch;
use crud\widgets\PageHeaderWidget;
use crud\library\widgets\JvectormapVisitorsWidget;
use crud\library\widgets\JvectormapMarkersWidget;


$options =[
    'controllerOptions'=>[
        "filter" =>function($action){return SettingsSwitch::getSwitch($action);}
    ]
];
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
$crawlers = Yii::$app->crawlers;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget($options) ?>
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



