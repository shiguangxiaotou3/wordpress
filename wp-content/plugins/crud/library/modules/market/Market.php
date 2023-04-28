<?php
namespace crud\modules\market;

use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use crud\models\AjaxAction;
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
            add_action("init", [$this, "registerAjax"]);
            add_action("rest_api_init", [$this, "registerRestfulApi"]);

        }
    }

    public function registerRestfulApi(){
        App::addApi($this->id);
    }

    public function registerAjax(){
//        $menus=[];
        $config =[
            'address','money','categorize','commodity',
            'commodity-price','express','storehouse','user'
        ];
        $actions =['init','index','create','view','update','delete','deletes'];
        foreach ($config as $menu){
            foreach ($actions as $action){
                $menuModel = new AjaxAction(['menu_slug'=>"market/".$menu."/".$action]);
                $menuModel->registerAjaxAction();
            }
        }
    }
}