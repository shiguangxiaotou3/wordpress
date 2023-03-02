<?php
namespace crud\widgets;

use Yii;
use yii\web\View;
use yii\base\Widget;
use yii\helpers\Html;
use crud\assets\ChartAsset;
use yii\helpers\ArrayHelper;
class PieChartWidget extends  Widget{

    public $id;
    private $_defaultOptions=[
        "segmentShowStroke" => true,
        "segmentStrokeColor" => '#fff',
        "segmentStrokeWidth" => 1,
        "percentageInnerCutout" => 50,
        "animationSteps" => 100,
        "animationEasing" => 'easeOutBounce',
        "animateRotate" => true,
        "animateScale" => false,
        "responsive" => true,
        "maintainAspectRatio" => false,
        "legendTemplate" => "<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<segments.length; i++){%><li><span style='background-color:<%=segments[i].fillColor%>'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
        "tooltipTemplate" => '<%=value %> <%=label%> users'
    ];
    public $options=[];
    public $pieOptions=[];
    public $pieData=[];

    public function run(){
        $pieOptions = json_encode( ArrayHelper::merge($this->_defaultOptions,$this->pieOptions),true);
        $pieData = json_encode($this->pieData);
        ChartAsset::register($this->view);
        $id = $this->options['id'];
        $js=<<<JS
            var pieChartCanvas = $("#{$id}").get(0).getContext('2d');
            var pieChart = new Chart(pieChartCanvas);
            var pieData ={$pieData};
            var pieOptions ={$pieOptions};
            pieChart.Doughnut(pieData , pieOptions );
JS;
        $this->view->registerJs($js);
        echo Html::beginTag("canvas",$this->options).Html::endTag("canvas");

    }
}
