<?php


namespace crud\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use crud\assets\ChartAsset;
use yii\helpers\ArrayHelper;






class LineChartWidget extends  Widget
{
    public $id;
    private $_defaultOptions=[
        "showScale" => true,
        "scaleShowGridLines" => false,
        "scaleGridLineColor" => 'rgba(0,0,0,.05)',
        "scaleGridLineWidth" => 1,
        "scaleShowHorizontalLines" => true,
        "scaleShowVerticalLines" => true,
        "bezierCurve" => true,
        "bezierCurveTension" => 0.3,
        "pointDot" => false,
        "pointDotRadius" => 4,
        "pointDotStrokeWidth" => 1,
        "pointHitDetectionRadius" => 20,
        "datasetStroke" => true,
        "datasetStrokeWidth" => 2,
        "datasetFill" => true,
        "legendTemplate" => '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        "maintainAspectRatio" => true,
        "responsive" => true
    ];
    public $options=[];
    public $lineOptions=[];

    /**
     * ~~~
     * ["labels"=>[],"datasets"=>[]]
     * ~~~
     * @var array
     */
    public $lineData=[];

    public function run(){
        $lineOptions = json_encode( ArrayHelper::merge($this->_defaultOptions,$this->lineOptions),true);
        $lineData = json_encode($this->lineData);
        ChartAsset::register($this->view);
        $id = $this->options['id'];
        $js=<<<JS
        var lineChartCanvas          = $('#{$id}').get(0).getContext('2d')
        var lineChart                = new Chart(lineChartCanvas)
        var lineChartOptions         = {$lineOptions}
        lineChartOptions.datasetFill = false
        lineChart.Line({$lineData}, lineChartOptions)
JS;
        $this->view->registerJs($js);
        return Html::beginTag("canvas",$this->options).Html::endTag("canvas");

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
