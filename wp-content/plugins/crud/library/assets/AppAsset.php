<?php
namespace crud\assets;

use Yii;
use yii\web\View;
use yii\web\AssetBundle;
use yii\base\InvalidConfigException;
/**
 * Class AppAsset
 * @property-read  $sourcePath
 * @package crud\assets
 */
class AppAsset extends WpAsset
{
    public $sourcePath = '@yii/assets';
    public $js = [
        'yii.js','yii.activeForm.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}