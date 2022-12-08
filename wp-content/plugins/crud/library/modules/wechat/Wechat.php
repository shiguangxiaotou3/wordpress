<?php


namespace crud\modules\wechat;

use Yii;
use yii\base\Module;
use yii\helpers\ArrayHelper;

class Wechat extends Module
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\wechat\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
//        $config =$this->config();
//        parent::init();
//        Yii::configure($this,$config);
    }

    public static function config(){
        require __DIR__ . '/config/bootstrap.php';
        return ArrayHelper::merge(
            require __DIR__ . '/config/main.php',
            require __DIR__ . '/config/main-local.php'
        );
    }
}