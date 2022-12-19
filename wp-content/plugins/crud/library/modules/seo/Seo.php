<?php


namespace crud\modules\seo;


use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use crud\modules\ModuleImplements;

class Seo extends Module implements ModuleImplements
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\seo\controllers';

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