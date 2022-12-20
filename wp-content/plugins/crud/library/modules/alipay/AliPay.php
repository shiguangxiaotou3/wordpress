<?php


namespace crud\modules\alipay;


use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use crud\modules\ModuleImplements;

class AliPay extends Module implements ModuleImplements
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\alipay\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
    }

    public static function config(){
        require __DIR__ . '/config/bootstrap.php';
        return ArrayHelper::merge(
            require __DIR__ . '/config/main.php',
            require __DIR__ . '/config/main-local.php'
        );
    }
}