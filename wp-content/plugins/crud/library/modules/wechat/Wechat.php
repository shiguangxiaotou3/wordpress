<?php
namespace crud\modules\wechat;

use Yii;
use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
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
            add_action("rest_api_init", [$this, "registerApi"]);
            Yii::$app->route($this->id);
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
     * 注册分享js
     */
    public function WechatShare(){
        $wechat = Yii::$app->subscription;
        $wechat->share();
    }

    /**
     * 验证开发者服务器
     */
    public function ValidateServer(){
        $wechat = Yii::$app->subscription;
        $echostr = $wechat->ValidateServer();
        if($echostr ){
            exit($echostr);
            die();
        }
    }

    /**
     *
     */
    public function getUserInfo(){
        if(isset($_GET['code']) and !empty($this)){
            $wechat = Yii::$app->subscription->getUserInfoByCode($_GET['code']);
            Yii::$app->subscription->getUserInfo( $wechat['openid']);
        }
    }

    public  function addUser(){
        $userId = wp_create_user("", "", "");
        add_user_meta($userId, 'openid', "");
        add_user_meta($userId, 'nickname', "");
        add_user_meta($userId, 'avatarurl', "");
        wp_set_current_user( $userId);
        wp_set_auth_cookie( $userId);
    }

    /**
     * 注册RestfulApi
     */
    public function registerApi()
    {
       App::addRestfulApi($this->id);
    }

    public function templateRedirect(){
        Yii::$app->templateRedirect($this->id);
    }
}