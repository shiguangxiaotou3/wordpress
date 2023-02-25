<?php


namespace crud\modules\pay;

use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;

class Pay extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\pay\controllers';

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
    public function bootstrap($app)
    {

    }
}