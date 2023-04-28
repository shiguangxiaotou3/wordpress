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
 *
 * @wordpress-plugin
 * Plugin Name:       Crud
 * Plugin URI:        https://www.shiguangxiaotou.com/
 * Description:       很多php开发者早习惯了面向对象和MVC模式,很不习惯wordpress面向函数、勾子的编程模式。那么crud能解决你的痛点crud插件不光是一个插件，也可以用来开发主题、api和进程守护程序。crud插件具备yii2所有的核型功能:组件、模块化、按需加载、依赖注入容器、高度可拓展、Gii、数据迁移、rbac、小部件等。不再需要你关注底层东西和wordpress的钩子，只需处理你的业务逻辑。crud与yii2最大的不同是：不再需要路由解析，这部分工作由wordpress完成。所有的控制器都需要提前注册。
 * Version:           1.0.0
 * Author:            ShiGuangXiaoTou
 * Author URI:        https://www.shiguangxiaotou.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */
defined('YII_DEBUG') or define('YII_DEBUG', WP_DEBUG);
defined('YII_ENV') or define('YII_ENV', 'dev');

require_once __DIR__ . "/library/debug.php";
require_once __DIR__ . "/library/function.php";
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require_once __DIR__ . '/common/config/bootstrap.php';

register_activation_hook(__FILE__, "crud_activate");
register_deactivation_hook(__FILE__, "crud_activate");
date_default_timezone_set('Asia/Shanghai');
//ini_set('magic_quotes_gpc',0);
header("Access-Control-Allow-Origin:*");
global $crud;
$crud = new backend\web\App();
$crud->run();
