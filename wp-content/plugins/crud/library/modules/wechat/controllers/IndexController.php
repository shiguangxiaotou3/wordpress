<?php
namespace crud\modules\wechat\controllers;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{

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
        return  $this->render("menu");
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
}