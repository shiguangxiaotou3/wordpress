<?php


namespace crud\modules\wp;


use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use crud\modules\ModuleImplements;

class Wp extends Module implements ModuleImplements
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\wp\controllers';

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
}