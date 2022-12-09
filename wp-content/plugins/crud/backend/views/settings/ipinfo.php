<?php
/** @var $this yii\web\View */

use crud\assets\ChartAsset;
use crud\models\SettingsSwitch;
use crud\widgets\WpTableWidget;
use crud\widgets\PieChartWidget;
use crud\widgets\BarChartWidget;

use crud\widgets\LineChartWidget;
use crud\widgets\PageHeaderWidget;

$options =[
    'controllerOptions'=>[
        "filter" =>function($action){return SettingsSwitch::getSwitch($action);}
    ]
];


ChartAsset::register($this);
$crawlers = Yii::$app->crawlers;
// 获取当天访问数据
$visitsRecords = $crawlers->getRecords();
$visits = $crawlers->visits(7);
$results = [
    "labels" => [],
    "datasets" => [
        [
            "label" => 'Visits',
            "fillColor" => 'rgba(60,141,188,0.9)',
            "strokeColor" => 'rgba(60,141,188,0.8)',
            "pointColor" => '#3b8bba',
            "pointStrokeColor" => 'rgba(60,141,188,1)',
            "pointHighlightFill" => '#fff',
            "pointHighlightStroke" => 'rgba(60,141,188,1)',
            "data" => []
        ]
    ]
];
foreach ($visits as $key => $re) {
    $results["labels"][] = date("d", $key) . "日";
    $results["datasets"][0]['data'][] = $re;
}
?>
    <div class="wrap">
        <?= PageHeaderWidget::widget($options) ?>
        <form action="options.php" method="post">
            <?php
            settings_fields("crud_group_ipinfo");
            do_settings_sections("settings/ipinfo");
            submit_button();
            ?>
        </form>
        <hr style="width: 100%;"/>
        <div style="display: flex;flex-wrap: wrap;justify-content: space-around">
            <div style="width: 500px;background-color: rgb(220,220,220);padding: 5px;margin: 5px 0">
                <?= PieChartWidget::widget([
                    "options" => ["id" => "pie", "style" => "height:250px"],
                    'pieOptions' => ["tooltipTemplate" => '<%=label%> :<%=value %>'],
                    "pieData" => $crawlers->visitsByBrowsers(7),]) ?>
            </div>
            <div style="width: 500px;background-color: rgb(220,220,220);padding: 5px;margin: 5px 0">
                <?= LineChartWidget::widget([
                    "options" => ["id" => "line", "style" => "height:250px"],
                    "lineData" => $results,
                    'lineOptions' => [],
                ]); ?>

            </div>
        </div>
        <hr style="width: 100%;"/>
        <?php
        if ($visitsRecords and is_array($visitsRecords)) {
            echo WpTableWidget::widget([
                "data" => $visitsRecords,
                'columns' => [
                    [
                        "field" => "time",
                        "title" => '时间戳',
                        "callback"=>function($row){
                            return date("H:i:s",$row['time']);
                        }
                    ],
                    [
                        "field" => "ip", "title" => 'ip'],
                    [
                        "field" => "city",
                        "title" => '城市',
                        "callback"=>function($row){
                            $str =[];
                            if(isset($row["country"])){
                                $str[] =  Yii::t("city",$row["country"]);
                            }
                            if(isset($row["region"])){
                                $str[] =  Yii::t("city",$row["region"]);
                            }
                            if(isset($row["city"])){
                                $str[] =  Yii::t("city",$row["city"]);
                            }
                            return join(",",$str);
                        }
                    ],
                    ["field" => "loc", "title" => '经纬度'],
                    ["field" => "browser", "title" => '浏览器'],
                    ["field" => "referer", "title" => '来路'],
                    ["field" => "isCrawler", "title" => '代理'],
                    ["field" => "matches", "title" => '爬虫名称'],
//                    ["field" => "dome", "title" => '域名'],
//                    ["field" => "url", "title" => '请求地址'],
//                    ["field" => "args", "title" => '请求参数'],
                ]
            ]);
        }
        ?>
    </div>
<?php


$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle) {
    $this->registerAssetFiles($name);
}