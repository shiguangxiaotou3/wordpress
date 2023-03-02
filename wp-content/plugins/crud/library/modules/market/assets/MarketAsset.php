<?php


namespace crud\modules\market\assets;


use crud\modules\wp\assets\WpAsset;

class MarketAsset extends WpAsset
{
    public $sourcePath =  "@library/modules/market/assets/market";
    public $css = ["css/index.css"];
    public $js = [];
    public $jsOptions=[];
    public $depends = [
        "yii\web\JqueryAsset",
        'crud\assets\VueAsset',
        'crud\assets\VuedraggableAsset'
    ];
}

