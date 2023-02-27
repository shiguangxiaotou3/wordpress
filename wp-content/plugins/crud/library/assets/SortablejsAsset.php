<?php
namespace crud\assets;

use yii\web\View;



class SortablejsAsset extends AppAsset {

    public $sourcePath =  "@bower/sortablejs";
    public $css = [
    ];
    public $js = ["Sortable.js"];
    public $jsOptions=[];
    public $depends = [];
}
