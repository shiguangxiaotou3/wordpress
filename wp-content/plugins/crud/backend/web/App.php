<?php

namespace backend\web;


use Yii;
use crud\Base;
use crud\models\Menu;
use yii\base\BaseObject;
use yii\web\Application;
use crud\models\Settings;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use PHPMailer\PHPMailer\PHPMailer as SMTP;

use crud\modules\wp\Wp;
use crud\modules\seo\Seo;
use crud\modules\crud\Crud;
use crud\modules\alipay\AliPay;
use crud\modules\editor\Editor;
use crud\modules\server\Server;
use crud\modules\wechat\Wechat;
use crud\modules\applets\Applets;
use crud\modules\translate\Translate;
use crud\modules\base\Base as BaseModule;


/**
 * App对象基类
 * @property-read yii\web\Application $app
 * @package crud\backend\web
 */
class App extends  BaseObject {

    private $_modules=[];

    public $_app;

    /**
     * 创建app对象
     * App constructor.
     * @throws InvalidConfigException
     */
    public function __construct(){
        require __DIR__ . '/../config/bootstrap.php';
        $config = ArrayHelper::merge(
            require __DIR__ . '/../../common/config/main.php',
            require __DIR__ . '/../../common/config/main-local.php',
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php',
            self::loadModulesConfig()
        );
        $this->_modules = array_keys($config['modules']);
        $this->_app = new Application($config);
    }

    /**
     * 加载模块配置
     * @return array
     */
    public static function loadModulesConfig(){
        // 加载模块配置
        return ArrayHelper::merge(
            BaseModule::config(),
            Editor::config(),
            Wp::config(),
            Wechat::config(),
            Translate::config(),
            AliPay::config(),
            Seo::config(),
            Crud::config(),
            Server::config(),
            Applets::config()
        );
    }

    /**
     * 获取app容器
     * @return Application
     * @throws InvalidConfigException
     */
    public function getApp(){
        if(!isset($this->_app) or empty($this->_app)){
            self::__construct();
        }
        return  $this->_app ;
    }

    /**
     * 挂载控制器
     */
    public function run(){
        // 前台应用注册钩子
        add_action('init',function (){
            /** @var Wp $wp */
            $wp = $this->app->getModule('wp');
            $wp->run();
        });

        // 将设置注册到特定的页面
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_init", [$this, "registerAjax"]);
        // 注册菜单 = 也就是注册yii Controller
        add_action("admin_menu", [$this, "registerPage"]);

        add_shortcode('post_parser', [$this,'renderView']);
        // 注册api
        add_action("rest_api_init", [$this,"registerRestfulApi"]);

        // 向后台页面调用视图事件，添加前端资源包
        add_action("admin_init", [$this, "beginPage"]);
        add_action("admin_head",[$this,"registerCsrfMetaTags"]);
        add_action("admin_head",[$this,"head"]);
        add_action("admin_body_open",[$this,"beginBody"]);
        add_action("admin_footer",[$this,"endBody"]);
        add_action("admin_footer",[$this,"endPage"]);



        // 配置邮箱
        add_action('phpmailer_init',[$this,"smtp"]);

        // 静止跟新
        add_filter('pre_site_transient_update_core',    function(){return null;}); // 关闭核心提示
        add_filter('pre_site_transient_update_plugins',  function(){return null;}); // 关闭插件提示
        add_filter('pre_site_transient_update_themes',   function(){return null;}); // 关闭主题提示
        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        remove_action('admin_init', '_maybe_update_themes');

    }

    /**
     * 配置发送邮箱
     * @param SMTP $mail
     */
    public function smtp($mail){

        // 发件人呢称
        $mail->FromName = get_option('crud_group_mail_blogname','');
        // smtp 服务器地址
        $mail->Host = get_option('crud_group_mail_host',"smtp.qq.com");
        // 端口号
        $mail->Port =get_option('crud_group_mail_port',465);
        // 账户
        $mail->Username =get_option('crud_group_mail_username','');
        // 密码
        $mail->Password =get_option('crud_group_mail_password','');
        // 收件人
        $mail->From =get_option('crud_group_mail_username','');;
        $mail->SMTPAuth =true;
        $mail->SMTPSecure =get_option('crud_group_mail_encryption',"ssl");
        $mail->isSMTP();
    }

    /**
     * 注册设置
     */
    public function registerSettings(){
        $settings = $this->app->params["settings"];
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册菜单和页面
     */
    public function registerPage(){
        $menus= $this->app->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new Menu($menu);
            $menuModel->registerMenu($this);
        }
    }

    /**
     * 注册ajax操作
     */
    public function registerAjax(){
        $menus= $this->app->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
        }
    }

    /**
     * 调用控制器显示视图
     */
    public function renderView(){
        $request = $this->app->request;
        $query =$request->queryParams;
        if($request->isAjax){
            if($request->isGet){
                $action =$request->get("action","");
            }else{
                $action = $request->post("action","");
            }
            unset( $query['action']);
            Base::sendJson($this->app->runAction($action));
        }else{
            try{
                $action= $query["page"];
                unset( $query['page']);
                Base::sendHtml($this->app->runAction($action,$query));
            }catch (\Exception $exception){
                Base::sendHtml($this->app->runAction("index/error",$query));
            }

        }
    }

    /**
     * 注册RestfulApi
     */
    public function registerRestfulApi(){
        /**
         *  * - `'PUT,PATCH users/<id>' => 'user/update'`: update a user
         * - `'DELETE users/<id>' => 'user/delete'`: delete a user
         * - `'GET,HEAD users/<id>' => 'user/view'`: return the details/overview/options of a user
         * - `'POST users' => 'user/create'`: create a new user
         * - `'GET,HEAD users' => 'user/index'`: return a list/overview/options of users
         * - `'users/<id>' => 'user/options'`: process all unhandled verbs of a user
         * - `'users' => 'user/options'`: process all unhandled verbs of user collection
         */

        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "PUT,PATCH",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "DELETE",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "POST",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        // 模块默认控制器
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "PUT,PATCH",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "DELETE",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "POST",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);

    }

    /**
     * 注册api配置
     * @param $request
     * @throws \yii\base\InvalidRouteException
     */
    public function renderApi($request){
        list($route ,$params) = $this->getRoute($request);
        try {
            $data = $this->app->runAction($route ,$params);
            Base::sendJson(   $data  );
        }  catch  (Exception $exception){
            Base::sendJson(
                [
                    'code'=>$exception->getCode(),
                    'message'=>$exception->getMessage(),
                    'trace'=>$exception->getTrace(),
                    "file"=>$exception->getFile()
                ]
            );
        }
    }
    public function getRoute($request){
        $params = $request->get_params();
        $module = $controller = $id ='';
        if (isset($params['id'])) {
            $id = $params["id"];
        }
        $action = $this->getMethod($id);

        if (isset($params['module'])){
            $module = $params['module'];
            unset($params['module']);
        }
        if (isset($params['controller'])) {
            $controller = $params["controller"];
            unset($params['controller']);
        }

        if(empty($module) && $this->is_module($controller)){
            $route = $controller."/api/index/".$action;
        }elseif(!empty($module) and !empty($controller) and !$this->is_module($controller)){
            $route =$module."/api/".$controller."/".$action;
        }else{
            $route ="api/".$controller.'/'.$action;
        }
        return [$route,$params];
    }
    public function getMethod($id){
        $method = Yii::$app->request->method;
        switch ($method) {
            case 'GET':
            case 'HEAD':
                $action = empty($id) ? "index" : "view";
                break;
            case 'POST':
                $action = "create";
                break;
            case 'PATCH':
            case 'PUT':
                $action = "update";
                break;
            case 'DELETE':
                $action = "delete";
                break;
            case 'OPTIONS':
                $action = "options";
            default:
                $action = "index";
        }
        return $action;
    }

    /**------------------------------
     * 为视图定义资源包缓存快,将Yii2视图事件回调
     *------------------------------*/
    public function registerCsrfMetaTags(){
        echo $this->app->view->registerCsrfMetaTags();
    }
    public function beginPage(){
        $this->app->view->beginPage();
    }
    public function head(){
        $this->app->view->head();
    }
    public function beginBody(){
        $this->app->view->beginBody();
    }
    public function endBody(){
        $this->app->view->endBody();
    }
    public function endPage(){
        $controller = $this->app->controller;
        if(isset($controller) and !empty($controller)){
            $controller->getView()->endPage();
        }
//        exit;
    }

    /**
     * @param $id
     * @return bool
     */
    private function is_module($id){
        return in_array($id, $this->_modules);
    }


}
