<?php
namespace crud\modules\wechat\controllers;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{

    public $layout= false;
    /**
     * 验证开发者服务器
     * @return false|string
     */
    public function actionIndex(){

       return  $this->render("index");
    }

    /**
     * 菜单设置
     * @return string
     */
    public function actionMenu(){
        $subscription =Yii::$app->subscription;
        return  $this->render("menu",['subscription'=>$subscription]);
    }
    /**
     * 事件
     * @return string
     */
    public function actionEvent(){
        return  $this->render("event");
    }

    public function actionShare(){
        return  $this->render("share");
    }

    public function actionTemplate(){
        return  $this->render("template");
    }

    public function actionMessage(){
        return  $this->render("@crud/views/ajax",[
            'activeUrl'=>'wechat/index/message',
            'title'=>'消息',
            'url_prefix'=>'wechat',
            'links'=>json_encode($this->links()),
            'tableName'=>'WechatMessage'
        ]);
    }
    private function links(){
        return [
            ["label" => "公众号", "url" => "wechat/index"],
            ["label" => "菜单设置", "url"=> "wechat/index/menu"],
            ["label" => "事件推送","url" => "wechat/index/event"],
            ["label" => "模版消息", "url"=> "wechat/index/template"],
            ["label" => "消息", "url"=> "wechat/index/message"],
            ["label" => "分享", "url" => "wechat/index/share"]
        ];
    }
}