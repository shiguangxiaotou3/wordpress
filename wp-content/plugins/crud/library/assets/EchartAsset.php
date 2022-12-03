<?php


namespace crud\assets;


class EchartAsset  extends AppAsset
{
    public $sourcePath =  "@bower/echart";
    public $css = [];
    public $js = ['jquery.js',"echarts.min.js"];
    public $jsOptions=[];
    public $depends = [];
}