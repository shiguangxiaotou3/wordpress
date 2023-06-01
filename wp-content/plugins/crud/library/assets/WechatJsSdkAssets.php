<?php
namespace crud\assets;

use Yii;

class WechatJsSdkAssets extends  WpAsset
{
    public $css = [];
    public $js = [ '//res.wx.qq.com/open/js/jweixin-1.6.0.js'];
    public $jsOptions=[];
    public $depends = ['yii\web\JqueryAsset'];
    public static function registerConfig($jsApiList=[], $debug=true){
        global  $wp;
        $url  =  urldecode(home_url(add_query_arg(array(),$wp->request)));

        $config =json_encode (Yii::$app->subscription->getJsConfig($url,$jsApiList,$debug));
        return 'wx.config('.$config.');';
    }
}