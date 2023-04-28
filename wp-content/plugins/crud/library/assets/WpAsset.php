<?php
namespace crud\assets;

use Yii;
use yii\web\View;
use yii\web\AssetBundle;
use yii\base\InvalidConfigException;
class WpAsset extends AssetBundle
{

    public $is_wp=false;

    /**
     * 获取
     * @return false|string
     */
    public  function publishedUrl(){
        if(!empty( $this->sourcePath) ){
            return Yii::$app->assetManager->getPublishedUrl($this->sourcePath);
        }
    }

    /**
     * @param $class
     * @param array $JsDepends
     * @param array $CssDepends
     * @throws InvalidConfigException
     */
    public static function registerAssets($class,&$JsDepends=[],&$CssDepends =[]){
        $bundle  =Yii::createObject(["class"=>$class]);
        if( !empty($bundle->depends )){
            foreach ($bundle->depends  as $item){
                if($item !=="yii\web\JqueryAsset"){
                    self::registerAssets($item,$JsDepends,$CssDepends);
                }else{
                    array_push($JsDepends ,  "jquery");
                }
            }
        }
        $path = $bundle->publishedUrl();
        $ver = basename( $path);
        $jsOptions =$bundle->jsOptions;
        if(isset($jsOptions['position']) and $jsOptions['position']== View::POS_END){
            $in_footer =true;
        }else{
             $in_footer =false;
        }
        foreach ($bundle->js as $js){
            $itemHandle = str_replace("/","-",$ver."/".$js);
            // 兼容外部js
            if(self::isHttp($js)){
                wp_register_script( $itemHandle, $js , $JsDepends,false, $in_footer);
            }else{
                wp_register_script( $itemHandle, $path."/".$js , $JsDepends,false, $in_footer);
            }
            array_push($JsDepends ,  $itemHandle);
        }
        foreach ($bundle->css as $css){
            $itemHandle = str_replace("/","-",$ver."/".$css);
            // 兼容外部css
            if(self::isHttp($css)){
                wp_register_style($itemHandle, $css , $CssDepends,false,"all");
            }else{
                wp_register_style($itemHandle, $path."/".$css , $CssDepends,false,"all");
            }
            array_push($CssDepends ,$itemHandle);
        }

        unset($bundle);
    }

    /**
     * @param View $view
     * @return WpAsset|AssetBundle
     * @throws InvalidConfigException
     */
    public static function register($view)
    {
        $class = get_called_class();
        $JsDepends=$CssDepends =[];
        self::registerAssets($class, $JsDepends,$CssDepends);
        if(is_array($JsDepends) AND !empty($JsDepends)){
            $handle =array_pop($JsDepends);
            wp_enqueue_script( $handle);
            unset($JsDepends);
        }
        if(is_array($CssDepends) AND !empty($CssDepends)){
            $handle =array_pop($CssDepends);
            wp_enqueue_style($handle );
            unset($CssDepends);
        }
        /** @wp WP_Dependencies*/
//        global $wp_styles;
//        global $wp_scripts;
        return $view->registerAssetBundle($class);
    }

    /**
     * 追加css
     * @param $view View
     * @param $file
     * @param array $options
     * @param null $key
     * @throws InvalidConfigException
     */
    public static function addCssFile($view,$file, $options = [], $key = null){
        $class = get_called_class();
        $bundle  =Yii::createObject(["class"=>$class]);
        $path = $bundle->publishedUrl();
        $ver = basename( $path);

        $itemHandle = str_replace("/","-",$ver."/".$file);
        $depends =[];
        if(!empty($bundle->css) and is_array($bundle->css)){
            $tmp =str_replace("/","-",$ver."/".array_pop($bundle->css));
            array_push($depends, $tmp );
        }
        unset($bundle);
        wp_enqueue_style(  $itemHandle, $path.$file , $depends , $key,'all' );
        $view->registerCssFile(  $path.$file, $options, $key );
    }

    /**
     * @param $view
     * @param $file
     * @param array $options
     * @param null $key
     * @throws InvalidConfigException
     */
    public static function addJsFile($view,$file,$options = [], $key = null){
        $class = get_called_class();
        $bundle  =Yii::createObject(["class"=>$class]);
        $path = $bundle->publishedUrl();
        $ver = basename( $path);
        if(isset($options['position']) and $options['position']== View::POS_END){
            $in_footer =true;
        }else{
            $in_footer =false;
        }
        $itemHandle = str_replace("/","-",$ver."/".$file);
        $depends =[];
        if(!empty($bundle->js) and is_array($bundle->js)  ){
            $tmp =str_replace("/","-",$ver."/".array_pop($bundle->js));
            array_push($depends, $tmp );
        }
        unset($bundle);
        wp_enqueue_script(  $itemHandle, $path.$file , $depends , $key, $in_footer);
        $view->registerJsFile(  $path.$file, $options, $key );
    }

    public static function isHttp($str){
        return preg_match("/^(http|https)/",$str);
    }
}

