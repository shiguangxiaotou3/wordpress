<?php
namespace crud\modules\sms;

use Yii;
use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;

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
            add_action("rest_api_init", [$this, "registerApi"]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerApi()
    {
        App::addApi($this->id);
    }
}