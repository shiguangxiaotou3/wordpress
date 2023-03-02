<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace crud\modules\crud;

use Yii;
use crud\Base;
use backend\web\App;
use yii\base\Module;
use yii\helpers\Json;
use yii\web\Application;
use yii\helpers\IpHelper;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use crud\modules\ModuleImplements;
use yii\base\NotSupportedException;
use yii\web\ForbiddenHttpException;
use yii\console\Application as ConsoleApp;

/**
 * This is the main module class for the Gii module.
 * 这是Gii模块的主模块类
 * To use Gii, include it as a module in the application configuration like the following:
 * 要使用Gii,请将其作为模块包含在应用程序配置中,如下所示：
 * ~~~
 * return [
 *     'bootstrap' => ['gii'],
 *     'modules' => [
 *         'gii' => ['class' => 'yii\gii\Module'],
 *     ],
 * ]
 * ~~~
 *
 * Because Gii generates new code files on the server, you should only use it on your own
 * development machine. To prevent other people from using this module, by default, Gii
 * can only be accessed by localhost. You may configure its [[allowedIPs]] property if
 * you want to make it accessible on other machines.
 *
 * With the above configuration, you will be able to access GiiModule in your browser using
 * the URL `http://localhost/path/to/index.php?r=gii`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Gii via URL: `http://localhost/path/to/index.php/gii`
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Crud extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\crud\controllers';
    /**
     * @var array the list of IPs that are allowed to access this module.
     * Each array element represents a single IP filter which can be either:
     * - an IP address (e.g. 1.2.3.4),
     * - an address with wildcard (e.g. 192.168.0.*) to represent a network segment
     * - a CIDR range (e.g. 172.16.0.0/12) (available since version 2.2.3).
     *   The default value is `['127.0.0.1', '::1']`, which means the module can only be accessed
     *   by localhost.
     */
    public $allowedIPs = ['59.174.48.91','127.0.0.1','119.98.220.193','119.98.220.12' ,'::1'];
    /**
     * @var array|Generator[] a list of generator configurations or instances. The array keys
     * are the generator IDs (e.g. "crud"), and the array elements are the corresponding generator
     * configurations or the instances.
     *
     * After the module is initialized, this property will become an array of generator instances
     * which are created based on the configurations previously taken by this property.
     *
     * Newly assigned generators will be merged with the [[coreGenerators()|core ones]], and the former
     * takes precedence in case when they have the same generator ID.
     */
    public $generators = [];
    /**
     * @var int the permission to be set for newly generated code files.
     * This value will be used by PHP chmod function.
     * Defaults to 0666, meaning the file is read-writable by all users.
     */
    public $newFileMode = 0666;
    /**
     * @var int the permission to be set for newly generated directories.
     * This value will be used by PHP chmod function.
     * Defaults to 0777, meaning the directory can be read, written and executed by all users.
     */
    public $newDirMode = 0777;

    /**
     * {@inheritdoc}
     */
    public function init(){
    }
    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
//            add_action("rest_api_init", [$this, "registerRestfulApi"]);
//            add_filter('status_header', [$this,"statusHeader"] );
            $app->getUrlManager()->addRules([
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => $this->id,
                    'route' => $this->id . '/default/index'
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => $this->id . '/<id:\w+>',
                    'route' => $this->id . '/default/view'
                ],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>',
                    'route' => $this->id . '/<controller>/<action>'
                ],
            ], false);
        } elseif ($app instanceof ConsoleApp) {
            $app->controllerMap[$this->id] = [
                'class' => 'crud\modules\crud\console\GenerateController',
                'generators' => array_merge($this->coreGenerators(), $this->generators),
                'module' => $this,
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app instanceof  Application && !$this->checkAccess()) {
            throw new ForbiddenHttpException(Yii::t("console", 'You are not allowed to access this page.'));
        }

        foreach (array_merge($this->coreGenerators(), $this->generators) as $id => $config) {
            if (is_object($config)) {
                $this->generators[$id] = $config;
            } else {
                $this->generators[$id] = Yii::createObject($config);
            }
        }

        $this->resetGlobalSettings();

        return true;
    }

    /**
     * Resets potentially incompatible global settings done in app config.
     * 重置在应用程序配置中完成的可能不兼容的全局设置
     */
    protected function resetGlobalSettings()
    {
        if (Yii::$app instanceof Application) {
            Yii::$app->assetManager->bundles = [];
        }
    }

    /**
     * @return int whether the module can be accessed by the current user
     * 当前用户是否可以访问该模块
     * @throws NotSupportedException
     */
    protected function checkAccess()
    {
        $ip = Yii::$app->getRequest()->getUserIP();
        foreach ($this->allowedIPs as $filter) {
            if ($filter === '*'
                || $filter === $ip
                || (
                    ($pos = strpos($filter, '*')) !== false
                    && !strncmp($ip, $filter, $pos)
                )
                || (
                    strpos($filter, '/') !== false
                    && IpHelper::inRange($ip, $filter)
                )
            ) {
                return true;
            }
        }
        Yii::warning(Yii::t('console','Access to Gii is denied due to IP address restriction. The requested IP is ') . $ip, __METHOD__);

        return false;
    }

    /**
     * Returns the list of the core code generator configurations.
     * 返回核心代码生成器配置的列表
     * @return array 核心代码生成器配置列表.
     */
    protected function coreGenerators()
    {
        return [
            'model' => ['class' => 'crud\modules\crud\generators\model\Generator'],
            'crud' => ['class' => 'crud\modules\crud\generators\crud\Generator'],
            'controller' => ['class' => 'crud\modules\crud\generators\controller\Generator'],
            'form' => ['class' => 'crud\modules\crud\generators\form\Generator'],
            'module' => ['class' => 'crud\modules\crud\generators\module\Generator'],
            'extension' => ['class' => 'crud\modules\crud\generators\extension\Generator'],
        ];
    }

    /**
     * {@inheritdoc}
     * @since 2.0.6
     */
    protected function defaultVersion()
    {
//        $packageInfo = Json::decode(file_get_contents(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'composer.json'));
//        $extensionName = $packageInfo['name'];
//        if (isset(Yii::$app->extensions[$extensionName])) {
//            return Yii::$app->extensions[$extensionName]['version'];
//        }
            return "2.2.5";
//        return parent::defaultVersion();
    }

    /**
     * @return array
     */
    public static function config()
    {
        require __DIR__ . '/config/bootstrap.php';
        return ArrayHelper::merge(
            require __DIR__ . '/config/main.php',
            require __DIR__ . '/config/main-local.php'
        );
    }

    /**
     * Filters an HTTP status header.
     * 过滤HTTP状态标头。
     * @since 2.2.0
     *
     * @param string $status_header HTTP status header.                 HTTP状态标头。
     * @param int    $code          HTTP status code.                   HTTP状态代码。
     * @param string $description   Description for the status code.    状态代码的说明
     * @param string $protocol      Server protocol.                    服务器协议.
     */
    public function statusHeader($status_header, $code, $description, $protocol){

    }

}
