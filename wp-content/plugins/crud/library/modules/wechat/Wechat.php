<?php
namespace crud\modules\wechat;

use Yii;
use crud\Base;
use backend\web\App;
use yii\base\InvalidRouteException;
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
//            add_action('login_form', [$this,'login']);
//            add_action('login_init',[$this,'getUserInfo']);
//            add_action("template_redirect",[$this,"ValidateServer"]);
//            add_action('the_content',[$this,'WechatShare']);
            add_action("rest_api_init", [$this, "registerApi"]);

            add_action('init', function () {
                add_rewrite_rule("^wechat$",
                    'index.php?wechat=index/index', "top");

                add_rewrite_rule("^wechat/([\w]+)$",
                    'index.php?wechat=$matches[1]/index', "top");

                add_rewrite_rule("^wechat/([\w]+)/([\w]+)$",
                    'index.php?wechat=$matches[1]/$matches[2]', "top");

                add_rewrite_rule("^wechat/([\w]+)/([\w]+)/([0-9]+)$",
                    'index.php?wechat=$matches[1]/$matches[2]&id=$matches[3]', "top");
            });
            add_filter('query_vars', function ($public_query_vars) {
                $public_query_vars[] = 'wechat';
                $public_query_vars[] = 'id';

                return $public_query_vars;
            });
            add_action("template_redirect", [$this, "templateRedirect"]);
        }
    }

    /**
     * 显示微信登录按钮
     */
    public function login(){
        $url =  Yii::$app->wechatSubscription->authorizationUrl('https://www.shiguangxiaotou.com/wp-login.php');
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
            $wechat = Yii::$app->wechatSubscription->getUserInfoByCode($_GET['code']);
            Yii::$app->wechatSubscription->getUserInfo( $wechat['openid']);
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


    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect()
    {
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['wechat']) and !empty($query_vars['wechat'])) {
            $route = 'wechat/'.$query_vars['wechat'];
            $params = $query_vars;
            $module = Yii::$app->getModule('wechat');
            $response = Yii::$app->response;
            $response->format = 'html';
            $response->setStatusCode(200);
            unset($query_vars['wechat']);
            if ($this->checkWpRoute($route)) {
                $response->data = $module->runAction($route, $params);
            } else {
                $response->data = $module->runAction("index/error", []);
            }
            $response->send();
            exit();
        }
    }

    /**
     * 检查某一个模块路由是否存在
     *
     * @param $route
     * @param string $moduleId
     *
     * @return bool
     */
    private function checkWpRoute($route, $moduleId = 'wechat')
    {
        $str = explode('/', $route);
        $count = count($str);
        $controllerId = $str[$count - 2];
        unset($str[$count - 2]);
        $actionId = $str[$count - 1];
        unset($str[$count - 1]);
        $namespace = trim(join("\\", $str));
        $controllerNamespace = "crud\modules\\" . $moduleId . "\controllers\\" .
            ($namespace != "" ? $namespace . "\\" : "") .
            ucfirst($controllerId) . "Controller";
        $actionName = 'action' . ucfirst($actionId);
        return Yii::$app->checkRoute($controllerNamespace, $actionName);
    }
}