<?php
namespace crud\modules\market;

use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
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
            add_action("rest_api_init", [$this, "registerRestfulApi"]);

        }
    }

    public function registerRestfulApi(){
        App::addApi($this->id);
    }
}