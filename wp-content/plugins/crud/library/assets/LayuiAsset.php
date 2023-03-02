<?php


namespace crud\assets;


class LayuiAsset extends AppAsset {

    public $sourcePath =  "@bower/layui";
    public $css = [
    ];
    public $js = [
        "layui.js"
    ];
    public $jsOptions=[];
    public $depends = ['yii\web\JqueryAsset'];
}
{

}