## Crud插件文档

### 前言

- 这是一个基于Yii2的MVC的插件框架,部分功能可能有待完善.
- 很多php开发者早习惯了面向对象和MVC模式,很不习惯wordpress面向函数、
  勾子的编程模式。那么crud能解决你的痛点
- crud插件不光是一个插件，也可以用来开发主题、api和进程守护程序
- crud插件具备yii2所有的核心功能:组件、模块化、按需加载、依赖注入容器、
  高度可拓展、Gii、数据迁移、rbac、小部件等。
- 不再需要你关注底层东西和wordpress的钩子，处理你的业务逻辑
- crud与yii2最大的不同是：不再需要路由解析，这部分工作由wordpress完成。所有的控制器都需要提前注册。

### 核心
 插件根`/wordpress/wp-content/plugins/curd`
 入口文件位于`/wordpress/wp-content/plugins/crud/crud.php`
 插件包含2个独立的应用分别是`backend`和`console`,`common`为两个应用公共配置.`console`为CLI应用
#### 加载
 入口文件`crud.php`作用是
- 定义常量
- 包含公共函数  
- 加载composer第三方依赖
- yii2应用初始化前的引导`/plugins/crud/common/config/bootstarp.php`
- 实例化应用

~~~php
<?php
/**
 * 插件引导文件
 *
 * 该文件由WordPress读取，以在插件管理区域生成插件信息。
 * 该文件还包括插件使用的所有依赖项,
 * 注册激活和停用功能, 并定义启动插件的函数.
 *
 * @link              https://www.shiguangxiaotou.com/
 * @since             1.0.0
 * @package           CRUD
 * @wordpress-plugin
 * Plugin Name:       Crud
 * Plugin URI:        https://www.shiguangxiaotou.com/
 * Description:       Curd 插件
 * Version:           1.0.0
 * Author:            ShiGuangXiaoTou
 * Author URI:        https://www.shiguangxiaotou.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
require_once __DIR__ . "/library/debug.php";
require_once __DIR__ . "/library/function.php";
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require_once __DIR__ . '/common/config/bootstrap.php';

register_activation_hook(__FILE__, "crud_activate");
register_deactivation_hook(__FILE__, "crud_activate");
date_default_timezone_set('Asia/Shanghai');
global $crud;
$crud = new backend\web\App();
$crud->run();

~~~

####  backend实例化
- 应用根目录为`/wordpress/wp-content/plugins/backend`
- 应用类被定义在`/web/App.php`

##### 应用配置加载
配置加载顺序:
- 1.首先包含应用的引导`backend/config/bootstarp.php`
- 2.加载公共配置配置(`common/config/main.php`和`common/config/main-local.php`)和
  应用配置(`backend/config/main.php`和`backend/config/main-local.php`)
- 3.接着调用`$this->loadModulesConfig()`获取子模块配置
- 4.最后将所有配置合并为数组`$config`传递给父类`parent::__construct($config);`
- 5.应用实例化完成

~~~php
<?php
namespace backend\web;

use crud\modules\wp\Wp;
use yii\web\Application;
use yii\helpers\ArrayHelper;
class App extends Application
{
    public function __construct()
    {
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
    
    public static function loadModulesConfig()
    {
        return ArrayHelper::merge(
            [
                'bootstrap' => ['wp' ],
            ],
            Wp::config()
        );
    }
}
?>
~~~

##### 应用实例化之后
- 应用实例化之后会自动调用`App::init()`或者子模块`Wp::init()`方法
- 接着根据全局配置中的`$config['bootstarp']`配置项完成子模块的引导.例如:

~~~php
<?php
$config=[
    'modules' => [
        'wp' => [
            'class' => "crud\modules\wp\Wp"
        ],
    ],
    'bootstarp'=>["wp"],//wp为子模块id
];
?>
~~~




##### 应用控制器挂载
 应用在初始化之完成之后将调用App::run()方法,将yii2的控制器挂载到wordpress的钩子中.
 由wordpress的钩子回调决定.执行哪一个控制器
 更多方法请查看源码[Github](https://github.com/shiguangxiaotou3/wordpress)
 例如

~~~php
<?php
    /**
     * 核心:将Yii2操作、事件等挂载到wordpress钩子上
     */
    public function run()
    {
        // +----------------------------------------------------------------------
        // ｜后台页面、设置、菜单，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_menu", [$this, "registerPage"]);

        // +----------------------------------------------------------------------
        // ｜Ajax、RestfulApi、路由配置、解析规则，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "registerAjax"]);
        add_action("rest_api_init", [$this, "registerRestfulApi"]);

        // +----------------------------------------------------------------------
        // ｜将yii\web\View事件挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "beginPage"]);
        add_action("admin_head", [$this, "registerCsrfMetaTags"]);
        add_action("admin_head", [$this, "head"]);
        add_action("admin_body_open", [$this, "beginBody"]);
        add_action("admin_footer", [$this, "endBody"]);
        add_action("admin_footer", [$this, "endPage"]);

        // +----------------------------------------------------------------------
        // ｜配置邮箱
        // +----------------------------------------------------------------------
        add_action('phpmailer_init', [$this, "smtp"]);

        // +----------------------------------------------------------------------
        // ｜过滤评论
        // +----------------------------------------------------------------------
        add_action('preprocess_comment', [$this, 'preprocessComment']);

        // +----------------------------------------------------------------------
        // ｜在插件旁边显示设置按钮
        // +----------------------------------------------------------------------
        add_filter('plugin_action_links', [$this, 'addSettingsButton'], 10, 2);

        // +----------------------------------------------------------------------
        // ｜静止自动更新
        // +----------------------------------------------------------------------
        add_filter('pre_site_transient_update_core', function () {
            return null;
        }); 
        // 关闭核心提示
        add_filter('pre_site_transient_update_plugins', function () {
            return null;
        }); 
        // 关闭插件提示
        add_filter('pre_site_transient_update_themes', function () {
            return null;
        }); 
        // 关闭主题提示
        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        remove_action('admin_init', '_maybe_update_themes');

        // +----------------------------------------------------------------------
        // ｜中国地区头像代理
        // +----------------------------------------------------------------------
        add_filter('get_avatar', function ($avatar) {
            return str_replace([
                'https://www.gravatar.com',
                'https://0.gravatar.com',
                'https://1.gravatar.com',
                'https://2.gravatar.com',
                'https://secure.gravatar.com',
                'https://cn.gravatar.com',
            ], 'http://103.215.125.122', $avatar);
        });
    }
~~~




##### 将子模块挂载到前端

~~~php
<?php

namespace crud\modules\wp;

use Yii;
use yii\base\Module;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
use yii\console\Application as ConsoleApplication;

/**
 * Class Wp
 *
 * @package crud\modules\wp
 */
class Wp extends Module implements BootstrapInterface
{

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\wp\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
        parent::init();
        $this->layout ='webslides';
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
        // 请不要忽略$app类名称检查的检查，因为console应用也会调用引导方法
        if ($app instanceof Application) {
            // +----------------------------------------------------------------------
            // ｜配置wp模块路由注册到前台和公共api路由
            // +----------------------------------------------------------------------
            // ｜http://youdomain.com/crud/ => wp/index/index
            // ｜http://youdomain.com/crud/<controller>/ => wp/<controller>/index
            // ｜http://youdomain.com/crud/<controller>/<action>/ => wp/<controller>/<action>
            // ｜http://youdomain.com/crud/<controller>/<action>/<id>/ => wp/<controller>/<action>/<id>
            add_action('init', function () {
                add_rewrite_rule("^crud$",
                    'index.php?crud=index/index', "top");

                add_rewrite_rule("^crud/([\w]+)$",
                    'index.php?crud=$matches[1]/index', "top");

                add_rewrite_rule("^crud/([\w]+)/([\w]+)$",
                    'index.php?crud=$matches[1]/$matches[2]', "top");

                add_rewrite_rule("^crud/([\w]+)/([\w]+)/([0-9]+)$",
                    'index.php?crud=$matches[1]/$matches[2]&id=$matches[3]', "top");
            });
            add_filter('query_vars', function ($public_query_vars) {
                $public_query_vars[] = 'crud';
                $public_query_vars[] = 'id';

                return $public_query_vars;
            });
            add_action("template_redirect", [$this, "templateRedirect"]);
            // +----------------------------------------------------------------------
            // ｜将yii\web\View事件挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("wp_head",[$this,"statistics"]);
            add_action("get_template_part_loop",[$this,"wpInit"]);

            add_action("wp_head",[Yii::$app,"registerCsrfMetaTags"]);
            add_action("wp_head",[Yii::$app,"head"]);
            add_action("wp_body_open",[Yii::$app,"beginBody"]);
            add_action("wp_footer",[Yii::$app,"endBody"]);
        }
        // 控制台应用引导 yii\console\Application
        if ($app instanceof ConsoleApplication) {

        }
    }

    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect()
    {
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['crud']) and !empty($query_vars['crud'])) {
            $route = $query_vars['crud'];
            $params = $query_vars;
            $module = Yii::$app->getModule('wp');
            $response = Yii::$app->response;
            $response->format = 'html';
            $response->setStatusCode(200);
            unset($query_vars['crud']);
            if ($this->checkWpRoute($route)) {
                $response->data = $module->runAction($route, $params);
            } else {
                $response->data = $module->runAction("index/error", []);
            }
            $response->send();
            exit();
        }
    }
}
~~~