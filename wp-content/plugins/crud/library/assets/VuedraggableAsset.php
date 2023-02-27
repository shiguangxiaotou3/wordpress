<?php
namespace crud\assets;

use yii\web\View;



class VuedraggableAsset extends AppAsset {

    public $sourcePath =  "@bower/vuedraggable/dist";
    public $css = [
    ];
    public $js = [
        "vuedraggable.umd.js"
    ];
    public $jsOptions=[];
    public $depends = ['crud\assets\VueAsset',"crud\assets\SortablejsAsset"];
}