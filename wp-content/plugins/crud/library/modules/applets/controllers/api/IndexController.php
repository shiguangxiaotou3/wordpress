<?php
namespace crud\modules\applets\controllers\api;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{

    public $layout = false;

    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex()
    {
        return [
            'globalStyle'=>[
                "color" => "#7A7E83",
                "selectedColor" => "#3cc51f",
                "borderStyle" => "black",
                "backgroundColor" => "#ffffff",
            ],
            "list" => [
                [
                    "pagePath" => "pages/index/index",
                    "iconPath" => "static/icons/default/a-xianxing_anquanbaozhangfuben58.png",
                    "selectedIconPath" => "static/icons/active/a-xianxing_anquanbaozhangfuben58.png",
                    "text" => "首页",
                ], [
                    "pagePath" => "pages/category/category",
                    "iconPath" => "static/icons/default/xianxing-21.png",
                    "selectedIconPath" => "static/icons/active/xianxing-21.png",
                    "text" => "商品"
                ], [
                    "pagePath" => "pages/news/news",
                    "iconPath" => "static/icons/default/a-xianxing_anquanbaozhangfuben47.png",
                    "selectedIconPath" => "static/icons/active/a-xianxing_anquanbaozhangfuben47.png",
                    "text" => "动态"
                ], [
                    "pagePath" => "pages/cart/cart",
                    "iconPath" => "static/icons/default/a-xianxing_anquanbaozhangfuben42.png",
                    "selectedIconPath" => "static/icons/active/a-xianxing_anquanbaozhangfuben42.png",
                    "text" => "购物车"
                ], [
                    "pagePath" => "pages/me/me",
                    "iconPath" => "static/icons/default/xianxing-07.png",
                    "selectedIconPath" => "static/icons/active/xianxing-07.png",
                    "text" => "我的"
                ]
            ],
            'reddot'=>[
                true,true,true,true,true
            ],
        ];
    }

    /**
     * 接收微信消息
     */
    public function actionCreate()
    {

    }

}