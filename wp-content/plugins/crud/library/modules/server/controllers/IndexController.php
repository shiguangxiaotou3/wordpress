<?php
namespace crud\modules\server\controllers;

use Yii;
use yii\web\Controller;
class IndexController extends Controller
{
    public $layout = false;

    public function actions(){
        return ['index','login'];
    }

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
        $data =Yii::$app->cache->get('server_login');
        if(!$data){
            $data =[];
        }
        return  $this->render("login",['data'=>$data]);
    }

}