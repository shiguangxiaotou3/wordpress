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
class AppAsset extends AssetBundle
{

    /**
     * 追加css
     * @param $view
     * @param $file
     * @param array $options
     * @param null $key
     * @throws InvalidConfigException
     */
    public static function addCssFile(&$view,$file, $options = [], $key = null){

        $asset = \Yii::createObject(["class"=>get_called_class()]);
        $path = $view->assetManager->getPublishedUrl($asset->sourcePath);
        $view->registerCssFile( $path.$file, $options, $key);
    }

    /**
     * @param $view
     * @param $file
     * @param array $options
     * @param null $key
     * @throws InvalidConfigException
     */
    public static function addJsFile(&$view,$file,$options = [], $key = null){
        $asset = Yii::createObject(["class"=>get_called_class()]);
        $path = $view->assetManager->getPublishedUrl($asset->sourcePath);
        $view->registerJsFile(  $path.$file, $options, $key );
    }

    /**
     * 获取
     * @return false|string
     */
    public  function publishedUrl(){
        if(!empty( $this->sourcePath) ){
            return Yii::$app->assetManager->getPublishedUrl($this->sourcePath);
        }
    }
}