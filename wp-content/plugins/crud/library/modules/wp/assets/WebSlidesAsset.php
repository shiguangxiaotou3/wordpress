<?php
namespace crud\modules\wp\assets;

use crud\assets\AppAsset;

class WebSlidesAsset extends AppAsset {
    public $sourcePath =  "@bower/webslides/static";
    public $css = ['css/svg-icons.css','css/webslides.css'];
    public $js = ['js/webslides.js','js/svg-icons.js'];
}