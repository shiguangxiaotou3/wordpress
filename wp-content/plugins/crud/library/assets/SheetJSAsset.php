<?php

namespace crud\assets;

class SheetJSAsset extends AppAsset {

    public $sourcePath =  "@bower/ExcelJs/dist";
    public $css = [];
    public $js = [
//        'https://cdn.jsdelivr.net/npm/vue-json-excel/dist/vue-json-excel.cjs.js',
        'vue-json-excel.umd.js'
    ];
    public $jsOptions=[];
    public $depends = [];
}