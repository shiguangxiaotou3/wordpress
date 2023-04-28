<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace crud\modules\gii;

use crud\assets\AppAsset;
/**
 * This declares the asset files required by Gii.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GiiAsset extends AppAsset
{
    public $sourcePath = '@yii/gii/assets';
    public $css = [
        'css/main.css',
    ];
    public $js = [
        'js/bs4-native.min.js',
        'js/gii.js',
    ];
    public $depends = [
        'crud\assets\AppAsset'
    ];
}
