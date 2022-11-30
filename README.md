<p align="center">
    <a href="https://https://github.com/shiguangxiaotou3/wordpress" target="_blank">
        <img src="https://www.shiguangxiaotou.com/favicon.ico" height="100px">
    </a>
    <h1 align="center">wordpress plugin CRUD for MVC </h1>
    <br>
</p>

### CRUD 是一个wordpress插件
 这是一个基于Yii2的MVC的插件框架,部分功能可能有待完善.
 对于习惯了面向对象的开发模式开发者,很不习惯wordpress面向函数,面向勾子的编程模式。那么crud能解决你的痛点
~~~
microsoft/bingads
crud                        根
  |-backend                 应用目录
  |--|--assets              资源类
  |--|--config              配置文件
  |--|--controllers         控制器
  |--|--models              模型
  |--|--runtime             临时数据缓存目录
  |--|--views               视图
  |--|--web                 入口文件目录
  |--|--|--assset           资源包发布目录
  |--|--|--App.php          应用实例类
  |-common                  公共应用
  |-console                 控制台应用
  |-frontend                前台应用
  |-library                 公共工具类
  |-vendor                  第三方拓展
  |-crud.php                插件入口
~~~

#### 插件入口文件crud.php
~~~php
define("CRUD_URL", plugin_dir_url(__FILE__));
defined("CRUD_DIR") or define("CRUD_DIR" ,__DIR__);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once __DIR__ . "/library/debug.php";            //测试工具函数
require_once __DIR__ . "/library/function.php";         //工具函数
require_once __DIR__ . '/vendor/autoload.php';          //自动夹子啊
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';  //Yii全局实例
require_once __DIR__ . '/common/config/bootstrap.php';  //全局引导配置别名

register_activation_hook(__FILE__, "crud_activate");    //激活插件
register_deactivation_hook(__FILE__, "crud_activate");  //禁用插件
date_default_timezone_set('Asia/Shanghai');

global $crud;
$crud = new backend\web\App();
$crud->run();
~~~
### 创建应用backend\web\App.php
~~~php
<?php
namespace backend\web;
use Yii;

use crud\App as BaseApp;
use crud\models\Menu;
use crud\models\Settings;
use yii\web\Application ;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use crud\modules\wechat\Wechat;


/**
 * App对象
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
           // Wechat::config(), 如果你加载了模块，请将模块的menu和settings加入到主配置中
           // 为后续registerSettings、registerPage、registerAjax，
           // registerRestfulApi调用
       
        );
        // 注意: 千万不要执行Application::run(),yii2/soft当作容器在使用
        // 决定运行那个控制器,不由yii2决定，而是wordpress的钩子回调决定。
        // wordpress会在根据不同的情况,调用renderView或renderApi。
        // 区别在于renderView用于处理用户的页面行为
        // renderApi 单独处理RestfulApi
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
        // 菜单的menu_slug = 路由，他将决定执行那个控制器,
        // 例如menu_slug =>"settings",它将回调执行SettingsController::actionIndex
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
    // 在后台中显示那个页面，由注册菜单式menu_slug值就是yii控制器id
    // 例如：http://wp.myweb.com/wp-admin/admin.php?page=wechat
    // 将回调执行$this->app->runAction("wechat/index")
    // 对于ajax请求
    // $.post("/wp-admin/admin-ajax.php",{action:"wechat/index"},function(){})
    // action字段决定由那个控制器处理请求，因为wordpress的ajax统一由admin-ajax.php处理
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
        }
    }

    /**
     * 注册RestfulApi
     */
    public function registerRestfulApi(){

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
        exit(json_encode( $action ,true));
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

~~~