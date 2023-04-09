<?php


namespace crud\assets;


class WechatJsSdkAssets extends  WpAsset
{
//    public $sourcePath =  "@bower/chart.js";
    public $css = [];
    public $js = ['http://res.wx.qq.com/open/js/jweixin-1.6.0.js'];
    public $jsOptions=[];
    public $depends = ['yii\web\JqueryAsset'];
}