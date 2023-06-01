<?php
namespace crud\modules\wechat;

use Yii;
use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
class Wechat extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\wechat\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
//        parent::init();
//        $this->layout =false;
    }

    /**
     * @return array
     */
    public static function config(){
        require __DIR__ . '/config/bootstrap.php';
        return ArrayHelper::merge(
            require __DIR__ . '/config/main.php',
            require __DIR__ . '/config/main-local.php'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app){
        if ($app instanceof Application) {
//            // +----------------------------------------------------------------------
//            // ｜微信公众号
//            // +----------------------------------------------------------------------
            add_action("rest_api_init", [$this->_api, "registerApi"]);
            add_action("init", [$this->_ajax, "registerAjax"]);
            $this->_frontendPage->registerFrontendRule($this->id,$this->id,'');
        }
    }

    /**
     * 显示微信登录按钮
     */
    public function login(){
        $url =  Yii::$app->subscription->authorizationUrl('https://www.shiguangxiaotou.com/wp-login.php');
        echo '<a 
        class="button button-primary button-large" 
        style="color:#fff;background: #2a0; float: right; margin: 18px 0 5px 10px; min-height: 32px;" 
        href="'.$url.'" type="button" >微信公众号登陆</a><br />';
    }

    /**
     * 注册RestfulApi
     */
    public function registerApi()
    {
       App::addRestfulApi($this->id);
    }

    /**
     * @return void
     * @throws InvalidRouteException
     */
    public function templateRedirect(){
        Yii::$app->templateRedirect($this->id);
    }

    public function registerAjax(){
        $config =[
            ['menu_slug'=>'wechat/menu/get-menu'],
            ['menu_slug'=>'wechat/menu/set-menu'],
            ['menu_slug'=>'wechat/menu/delete-menu'],
            ['menu_slug'=>'wechat/template-message/list'],
            ['menu_slug'=>'wechat/template-message/send'],
            ['menu_slug'=>'wechat/template-message/delete'],
            ['menu_slug'=>'wechat/action/access-token'],
            ['menu_slug'=>'wechat/action/ticket'],
            ['menu_slug'=>'wechat/action/cache'],
        ];
        $controller =[
            'wechat-message'
        ];
        $actions =['init','index','create','view','update','delete','deletes'];
        foreach ($controller as $item){
            foreach ($actions as $action){
                $config[] =['menu_slug'=>"wechat/". $item."/".$action];
            }
        }

        foreach ($config as $menu){
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction();

        }
    }
}