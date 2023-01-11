<?php


namespace crud\assets;

use Yii;
use yii\web\View;
use yii\web\AssetBundle;




class AppAsset extends AssetBundle
{
    /**
     * 追加css
     * @param View $view
     * @param $file
     * @param array $options
     * @param null $key
     */
    public static function addCssFile(&$view,$file, $options = [], $key = null){

        $asset = \Yii::createObject(["class"=>get_called_class()]);
        $path = $view->assetManager->getPublishedUrl($asset->sourcePath);
        $view->registerCssFile( $path.$file, $options, $key);
    }

    /**
     * 追加js
     * @param View $view
     * @param $file
     * @param array $options
     * @param null $key
     */
    public static function addJsFile(&$view,$file,$options = [], $key = null){
        $asset = Yii::createObject(["class"=>get_called_class()]);
        $path = $view->assetManager->getPublishedUrl($asset->sourcePath);
        $view->registerJsFile(  $path.$file, $options, $key );
    }
}