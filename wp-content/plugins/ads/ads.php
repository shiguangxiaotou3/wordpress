<?php
/**
 * 插件引导文件
 *
 * 该文件由WordPress读取，以在插件管理区域生成插件信息。
 * 该文件还包括插件使用的所有依赖项,
 * 注册激活和停用功能, 并定义启动插件的函数.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           CRUD
 * @wordpress-plugin
 * Plugin Name:       Ads
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       我的插件生成器
 * Version:           1.0.0
 * Author:            ShiGuangXiaoTou
 * Author URI:        http://www.shiguangxiaotou.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugin-name
 * Domain Path:       /languages
 */
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');


require_once __DIR__ . "/src/debug.php";
require_once  __DIR__."/src/function.php";
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require_once __DIR__."/backend/config/bootstrap.php";


register_activation_hook(__FILE__, "crud_activate");
register_deactivation_hook(__FILE__, "crud_activate");
date_default_timezone_set('Asia/Shanghai');

$ads = new \backend\web\App();
$ads->run();