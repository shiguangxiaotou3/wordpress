<p align="center">
    <a href="https://https://github.com/shiguangxiaotou3/wordpress" target="_blank">
        <img src="https://www.shiguangxiaotou.com/favicon.ico" height="100px">
    </a>
    <h1 align="center">wordpress plugin CRUD for MVC </h1>
    <br>
</p>

### CRUD 是一个wordpress插件
- 这是一个基于Yii2的MVC的插件框架,部分功能可能有待完善.
- 很多php开发者早习惯了面向对象和MVC模式,很不习惯wordpress面向函数、勾子的编程模式。那么crud能解决你的痛点
- crud插件不光是一个插件，也可以用来开发主题、api和进程守护程序
- crud插件具备yii2所有的核型功能:组件、模块化、按需加载、依赖注入容器、高度可拓展、Gii、数据迁移、rbac、小部件等。
- 不再需要你关注底层东西和wordpress的钩子，处理你的业务逻辑
- crud与yii2最大的不同是：不再需要路由解析，这部分工作由wordpress完成。所有的控制器都需要提前注册。
### 安装
~~~shell
composer create-project shiguangxiaotou/wordpress:dev-master -vvv
~~~

~~~json
{
  "require-dev": {
    "yiisoft/yii2-debug": "~2.1.0",
    "yiisoft/yii2-gii": "~2.2.0",
    "yiisoft/yii2-faker": "~2.0.0",
    "phpunit/phpunit": "~9.5.0",
    "codeception/codeception": "^5.0.0 || ^4.0",
    "codeception/lib-innerbrowser": "^3.0 || ^1.1",
    "codeception/module-asserts": "^3.0 || ^1.1",
    "codeception/module-yii2": "^1.1",
    "codeception/module-filesystem": "^3.0 || ^2.0 || ^1.1",
    "codeception/verify": "^2.2",
    "symfony/browser-kit": "^6.0 || >=2.7 <=4.2.4"
  } 
}

~~~

~~~
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
  |-console                 控制台应用(控制台入口在你的项目根/cmmand)
  |-library                 公共工具类
  |-vendor                  第三方拓展
  |-crud.php                插件入口
~~~
#### 依赖

![依赖](https://www.shiguangxiaotou.com/wp-content/uploads/2023/01/截屏2023-01-07-02.33.19.png)

#### 插件入口文件crud.php
~~~php
define("CRUD_URL", plugin_dir_url(__FILE__));
defined("CRUD_DIR") or define("CRUD_DIR" ,__DIR__);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once __DIR__ . "/library/debug.php";            //测试工具函数
require_once __DIR__ . "/library/function.php";         //工具函数
require_once __DIR__ . '/vendor/autoload.php';          //自动夹子啊
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';  //yii核心
require_once __DIR__ . '/common/config/bootstrap.php';  //全局引导类

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
use crud\modules\wp\Wp;
use yii\web\Application;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\InvalidRouteException;
use yii\base\InvalidConfigException;
use PHPMailer\PHPMailer\PHPMailer as SMTP;


/**
 * App对象基类
 * @property-read yii\web\Application $app
 * @package crud\backend\web
 */
class App extends  Application {

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
            $this->loadModulesConfig()
        );
        parent::__construct($config);
    }

    /**
     * 引导模块初始化
     *
     * backend\web\App初始化之后,执行所配置模块的init()方法
     * 例如：crud\modules\wp\Wp::init()方法优先级大于backend\web\App::run()方法
     * 请不要在init()调用global $crud; 此时初始化未完成
     * 请不要将模块id和组件id重名
     * @return string[]
     */
    public static function loadModulesConfig(){
        // +----------------------------------------------------------------------
        // ｜子模块引导配置
        // +----------------------------------------------------------------------
        // ｜App实例化时候会根据bootstrap配置项调用模块的bootstrap(),引导wordpress挂载
        // ｜例如:['bootstrap'=>['wp']] =>crud\modules\wp\Wp::bootstrap()
        // +----------------------------------------------------------------------
        $config = [
            'bootstrap'=>['wechat','wp'],
        ];
        return ArrayHelper::merge(
            Wp::config(),
            $config
        );
    }

    /**
     * 核心:将Yii2操作、事件等挂载到wordpress钩子上
     */
    public function run(){
        // +----------------------------------------------------------------------
        // ｜配置wp模块和公共api路由
        // +----------------------------------------------------------------------
        // ｜http://youdomain.com/crud/ => wp/index/index
        // ｜http://youdomain.com/crud/<controller>/ => wp/<controller>/index
        // ｜http://youdomain.com/crud/<controller>/<action>/ => wp/<controller>/<action>
        // ｜http://youdomain.com/crud/<controller>/<action>/<id>/ => wp/<controller>/<action>/<id>
        add_action('init', function (){
            add_rewrite_rule('^crud[/]?$',
                'index.php?crud=index/index','top');

            add_rewrite_rule('^crud[/]([\w]+)[/]?$',
                'index.php?crud=$matches[1]/index','top');

            add_rewrite_rule('^crud[/]([\w]+)/([\w]+)[/]?$',
                'index.php?crud=$matches[1]/$matches[2]','top');

            add_rewrite_rule('^crud[/]([\w]+)[/]([\w]+)[/]([0-9]+)[/]?$',
                'index.php?crud=$matches[1]/$matches[2]&id=$matches[3]','top');
        });
        add_filter('query_vars',function ($public_query_vars){
            $public_query_vars[] = 'crud';
            $public_query_vars[] = 'id';
            $public_query_vars[] = 'api';
            return $public_query_vars;
        });
        add_action("template_redirect", [$this,"templateRedirect"]);

        // +----------------------------------------------------------------------
        // ｜后台页面、设置、菜单，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_menu", [$this, "registerPage"]);


        // +----------------------------------------------------------------------
        // ｜Ajax、RestfulApi、路由配置、解析规则，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "registerAjax"]);
        add_action("rest_api_init", [$this,"registerRestfulApi"]);

        // +----------------------------------------------------------------------
        // ｜将yii\web\View事件挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "beginPage"]);
        add_action("admin_head",[$this,"registerCsrfMetaTags"]);
        add_action("admin_head",[$this,"head"]);
        add_action("admin_body_open",[$this,"beginBody"]);
        add_action("admin_footer",[$this,"endBody"]);
        add_action("admin_footer",[$this,"endPage"]);

        // +----------------------------------------------------------------------
        // ｜配置邮箱
        // +----------------------------------------------------------------------
        add_action('phpmailer_init',[$this,"smtp"]);

        // +----------------------------------------------------------------------
        // ｜过滤评论
        // +----------------------------------------------------------------------
        add_action('preprocess_comment',[$this,'preprocessComment']);

        // +----------------------------------------------------------------------
        // ｜静止自动更新
        // +----------------------------------------------------------------------
        add_filter('pre_site_transient_update_core',    function(){return null;}); // 关闭核心提示
        add_filter('pre_site_transient_update_plugins',  function(){return null;}); // 关闭插件提示
        add_filter('pre_site_transient_update_themes',   function(){return null;}); // 关闭主题提示
        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        remove_action('admin_init', '_maybe_update_themes');

    }

    // +----------------------------------------------------------------------
    // ｜后台页面、设置、菜单等，注册和回调
    // +----------------------------------------------------------------------
    /**
     * 注册设置
     * @param string $moduleId
     */
    public function registerSettings($moduleId=''){}

    /**
     * 注册菜单和页面
     * @param string $moduleId
     */
    public function registerPage($moduleId=''){}

    /**
     * 调用控制器显示视图
     * @throws InvalidRouteException
     */
    public function renderView(){}

    // +----------------------------------------------------------------------
    // ｜Ajax、RestfulApi、路由配置、解析规则，注册、配置和回调
    // +----------------------------------------------------------------------
    /**
     * 注册控制器ajax操作
     */
    public function registerAjax(){
        $menus= $this->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
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


        }

    /**
     * 将RestfulApi解析到指定的控制器
     * @param $request
     * @throws InvalidRouteException
     */
    public function renderApi($request){}

    /**
     * 配置发送邮箱
     * @param SMTP $mail
     */
    public function smtp($mail){}

    // +----------------------------------------------------------------------
    // ｜yii\web\View事件的回调(用于在视图中加载前端资源包)
    // +----------------------------------------------------------------------
    public function beginPage(){}
    public function registerCsrfMetaTags(){}
    public function head(){}
    public function beginBody(){}
    public function endBody(){}
    public function endPage(){}

    /**
     * 过滤评论
     */
    public function preprocessComment(){}

    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect(){
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['crud']) and !empty($query_vars['crud'])) {
            $route=$query_vars['crud'];
            unset($query_vars['crud']);
            $params=$query_vars;
            $module =Yii::$app->getModule('wp');
            $response = Yii::$app->response;
            $response->format ='html';
            $response->setStatusCode(200);
            $response->data =$module->runAction($route,$params);
            exit($response->send());
        }
        if(isset($query_vars['api'])){
            dump($query_vars);
            die();
        }
    }
}


~~~