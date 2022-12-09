<?php


namespace crud\modules\wechat\controllers\api;

use crud\controllers\RestfulApiControllerImplements;
use Yii;
use Exception;
use yii\web\Controller;

class MenuController extends Controller
{

    public $layout = false;

    /**
     * 获取菜单
     */
    public function actionIndex(){
        $cache =Yii::$app->cache;
        $menus = $cache->get("wechat_menus");
        if(empty($menus)){
            $wechat = Yii::$app->wechat;
            $menus =$wechat->menu;
            if($menus['code']== 1){
                $cache->set("wechat_menus",$menus);
            }
        }
        return $menus;
    }

    /**
     * 创建菜单
     */
    public function actionCreate(){
        $wechat = Yii::$app->wechat;
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