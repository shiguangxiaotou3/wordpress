<?php

namespace crud\assets;

class CrudAsset extends AppAsset
{
    public $sourcePath =  "@library/modules/crud/assets";
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/bs4-native.min.js',
        'js/gii.js',
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}