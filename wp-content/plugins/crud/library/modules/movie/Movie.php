<?php
namespace crud\modules\movie;

use Yii;
use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
class Movie extends Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\movie\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
//        parent::init();
//        $this->layout =false;
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
//            // +----------------------------------------------------------------------
//            // ｜微信公众号
//            // +----------------------------------------------------------------------
            add_action("rest_api_init", [$this->_api, "registerApi"]);
            add_action("init", [$this->_ajax, "registerAjax"]);
            $this->_frontendPage->registerFrontendRule($this->id,$this->id,'');
//            Yii::$app->route($this->id,$this->id,'');
        }
    }

    /**
     * @return void
     * @throws InvalidRouteException
     */
    public function templateRedirect(){
        Yii::$app->templateRedirect($this->id);
    }

    public function registerAjax(){

    }

    public function registerApi(){
        App::addApi($this->id);
    }
}