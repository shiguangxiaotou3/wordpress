<?php


namespace crud\modules\wechat\controllers\api;

use Yii;
use Exception;
use yii\web\Response;
use yii\web\Controller;

class MenuController extends Controller
{

    public $layout = false;

    /**
     * 获取菜单
     */
    public function actionIndex(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $wechat = Yii::$app->subscription;
        return  $wechat->menu;
    }

    /**
     * 创建菜单
     */
    public function actionCreate(){
        $wechat = Yii::$app->subscription;
        $menu =Yii::$app->request->post();
        if(isset($menu["matchrule"])){
            $response =$wechat->setConditionalMenu($menu);
        }else{
            $response = $wechat->setMenu($menu);
        }
        $cache =Yii::$app->cache;
        $cache->set("wechat_menus", $response );
        return $response;
    }
}