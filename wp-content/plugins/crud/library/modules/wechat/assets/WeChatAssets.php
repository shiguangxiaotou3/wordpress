<?php


namespace crud\modules\wechat\assets;

use Yii;
use yii\web\AssetBundle;




class WeChatAssets extends AssetBundle
{
    public $sourcePath =  "http://res.wx.qq.com/open/js/jweixin-1.6.0.js";
    public $css = [];
//    public $js = ['jweixin-1.6.0.js'];
    public $jsOptions=[];
    public $depends = [];
    public static function registerConfig($jsApiList=[], $debug=true){
        global  $wp;
        $url  =  urldecode(home_url(add_query_arg(array(),$wp->request)));
        $config = json_encode( Yii::$app->wechatSubscription->getJsConfig($url,$jsApiList,$debug));
        $js =<<<JS
        wx.config({$config});
JS;
        return $js;
    }
}