<?php


namespace crud\modules\server;

use Yii;
use yii\base\Module;
use yii\base\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use crud\modules\ModuleImplements;





class Server extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\server\controllers';

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

    public function bootstrap($app)
    {
        // TODO: Implement bootstrap() method.
    }
}