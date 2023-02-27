<?php
namespace crud\common\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use crud\common\assets\ChartAsset;



class BarChartWidget extends  Widget
{
    public $id;
    private $_defaultOptions=[
        "scaleBeginAtZero" => true,
        "scaleShowGridLines" => true,
        "scaleGridLineColor" => 'rgba(0,0,0,.05)',
        "scaleGridLineWidth" => 1,
        "scaleShowHorizontalLines" => true,
        "scaleShowVerticalLines" => true,
        "barShowStroke" => true,
        "barStrokeWidth" => 2,
        "barValueSpacing" => 5,
        "barDatasetSpacing" => 1,
        "legendTemplate" => '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        "responsive" => true,
        "maintainAspectRatio" => true
    ];
    public $options=[];
    public $barOptions=[];

    /**
     * ~~~
     * ["labels"=>[],"datasets"=>[]]
     * ~~~
     * @var array
     */
    public $barData=[];

    public function run(){
        $barOptions = json_encode( ArrayHelper::merge($this->_defaultOptions,$this->barOptions),true);
        $barData = json_encode($this->barData);
        ChartAsset::register($this->view);
        $id = $this->options['id'];
        echo Html::beginTag("canvas",$this->options).Html::endTag("canvas");
        $js=<<<JS
        var barChartCanvas                   = $('#{$id}').get(0).getContext('2d')
        var barChart                         = new Chart(barChartCanvas)
        var barChartData                     = {$barData}
        barChartData.datasets[1].fillColor   = '#00a65a'
        barChartData.datasets[1].strokeColor = '#00a65a'
        barChartData.datasets[1].pointColor  = '#00a65a'
        var barChartOptions                  = {$barOptions}
        barChartOptions.datasetFill = false
        barChart.Bar(barChartData, barChartOptions);
JS;
        $this->view->registerJs($js);
    }
}
<<<JS
    var barChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        }
      ]
    }
JS;
