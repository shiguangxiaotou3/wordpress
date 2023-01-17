<?php


namespace crud\assets;


class ChartAsset extends AppAsset {
    public $sourcePath =  "@bower/chart.js";
    public $css = [];
    public $js = ['Chart.js'];
    public $jsOptions=[];
    public $depends = ['yii\web\JqueryAsset'];
}