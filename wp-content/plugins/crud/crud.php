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
 *
 * @wordpress-plugin
 * Plugin Name:       CRUD
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

/**
 * @const string CRUD_URL
 */
define("CRUD_URL", plugin_dir_url(__FILE__));
defined("CRUD_DIR") or define("CRUD_DIR" ,__DIR__);
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

/**
 *
 * @property-read $api
 * @property-read $backend
 * @property-read $frontend
 * Class crud
 */
class crud extends \yii\base\BaseObject {

    public $_api;
    public $_backend;
    public $_frontend;

    /**
     * crud constructor.
     */
    public function __construct(){
        $this->_api = new api\web\App();
        $this->_backend = new backend\web\App();
        $this->_frontend =new frontend\web\App();
    }

    /**
     * @return  api\web\App
     */
    public function getApi(){
        return $this->_api->app;
    }

    /**
     * @return \yii\web\Application
     */
    public function getBackend(){

        return $this->_backend->app;
    }

    /**
     * @return \yii\web\Application
     */
    public function getFrontend(){
        return $this->_frontend->app;
    }

    /**
     * 运行容器
     */
    public function run(){
        $this->_api->run();
        $this->_backend->run();
        $this->_frontend->run();
    }

}

global $crud;
$crud =new crud();
$crud->run();




