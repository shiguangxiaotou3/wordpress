<?php

namespace backend\web;


use crud\modules\wechat\Wechat;
use Yii;
use crud\App as BaseApp;
use crud\models\Menu;
use crud\models\Settings;
use yii\web\Application ;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;


/**
 * App对象基类
 * @property-read Application $app
 * @package crud\backend\web
 */
class App extends  BaseApp {

    public $_app;
    /**
     * 创建app对象
     * @throws yii\base\InvalidConfigException
     */
    public function __construct(){
        require __DIR__ . '/../config/bootstrap.php';
        $config = ArrayHelper::merge(
            require __DIR__ . '/../../common/config/main.php',
            require __DIR__ . '/../../common/config/main-local.php',
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php',
            Wechat::config()
        );
        $this->_app = new Application($config);
    }

    /**
     * 获取app容器
     * @throws Yii\base\InvalidConfigException
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
        // 将设置注册到特定的页面
        add_action("admin_init", [$this, "registerSettings"]);
        // 注册菜单 = 也就是注册yii Controller
        add_action("admin_menu", [$this, "registerPage"]);
        add_action("admin_init", [$this, "registerAjax"]);

        // 注册api
        add_action("rest_api_init", [$this,"registerRestfulApi"]);

        // 为资源包文件创建缓存快，
        add_action("admin_init", [$this, "beginPage"]);
        add_action("admin_head",[$this,"registerCsrfMetaTags"]);
        add_action("admin_head",[$this,"head"]);
        add_action("admin_body_open",[$this,"beginBody"]);
        add_action("admin_footer",[$this,"endBody"]);
        add_action("admin_footer",[$this,"endPage"]);
    }

    /**
     * 注册设置
     */
    public function registerSettings(){
        $settings = $this->app->params["settings"];
        logObject($settings['wechat']);
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
        if($request->isAjax){
            if($request->isGet){
                $action =$request->get("action","");
            }else{
                $action = $request->post("action","");
            }
            $data = $this->app->runAction($action);
            $this->sendJson($data);
        }else{
            $query =$request->queryParams;
            $action= $query["page"];
            exit( $this->app->runAction($action));
//            exit(  $action);
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
        // 模块默认控制器
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "PUT,PATCH",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "DELETE",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)", [
            'methods' => "POST",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
    }

    /**
     * @param $request
     * @throws \yii\base\InvalidRouteException
     */
    public function renderApi($request){
        list($route ,$params) = $this->getRoute($request);
        $data = $this->app->runAction($route ,$params);
        exit( $data);
    }

    public function getRoute($request){
        $params =$request->get_params();
        $module = $controller =$id="";
        if(isset($params['module'])){
            $module = $params['module'];
            unset( $params['module']);
        }
        if(isset($params['controller'])){
            $controller = $params["controller"];
            unset( $params['controller']);
        }
        if(isset($params['id'])){
            $id = $params["id"];
        }

        $method = Yii::$app->request->method;
        switch ($method){
            case 'GET':
                $action = empty($id)?"index":"view";
            case 'HEAD':
                $action = empty($id)?"index":"view";
            case 'POST':
                $action = "create";
            case 'PUT':
                $action = "update";
            case 'PATCH':
                $action = "update";
            case 'DELETE':
                $action = "delete";
            case 'OPTIONS':
                $action = "options";
        }

        /**
         *  * - `'PUT,PATCH users/<id>' => 'user/update'`: update a user
         * - `'DELETE users/<id>' => 'user/delete'`: delete a user
         * - `'GET,HEAD users/<id>' => 'user/view'`: return the details/overview/options of a user
         * - `'POST users' => 'user/create'`: create a new user
         * - `'GET,HEAD users' => 'user/index'`: return a list/overview/options of users
         * - `'users/<id>' => 'user/options'`: process all unhandled verbs of a user
         * - `'users' => 'user/options'`: process all unhandled verbs of user collection
         */
        exit(json_encode( $action ,true));
//        return [];
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

    }
}
