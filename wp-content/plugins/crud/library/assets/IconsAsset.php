<?php


namespace crud\assets;

use yii\web\AssetBundle;

class IconsAsset extends AssetBundle{

    public $sourcePath =  "@bower/webslides";
    public $css = ['static/css/svg-icons.css'];
    public $js = ['svg-icons.js'];
    public $jsOptions=[];
    public $depends = [];
}
