<?php


namespace crud\modules\market;

use Yii;
use crud\Base;
use yii\base\Module;
use crud\models\Menu;
use yii\web\Application;
use crud\models\Settings;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;

class Market extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $layout = false;
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\market\controllers';
    /**
     * {@inheritdoc}
     */
    public function init(){
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
          // +----------------------------------------------------------------------
          // ｜商场 子模块加载完毕引导
          // +----------------------------------------------------------------------
          add_action('admin_enqueue_scripts', [$this ,"registerMedia"]);
        }
    }

    /**
     * 注册js
     */
    public function registerMedia()
    {
        logObject("执行了");
        wp_enqueue_media();
    }

}