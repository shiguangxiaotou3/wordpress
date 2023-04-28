<?php
namespace crud\modules\applets\controllers;

use Yii;
use yii\web\Controller;

class IndexController extends Controller
{
    public $layout = false;

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
    public function actionLogin(){
        return  $this->render("login",['data'=>Yii::$app->cache->get('server_login')]);
    }

}