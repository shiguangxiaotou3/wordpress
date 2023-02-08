<?php


namespace crud\modules\sms;

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


class Sms extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\sms\controllers';

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

        }
    }
}