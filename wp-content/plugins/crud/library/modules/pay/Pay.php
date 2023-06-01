<?php
namespace crud\modules\pay;

use Yii;
use backend\web\App;
use yii\base\Module;
use yii\web\Application;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
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
        if ($app instanceof Application) {
            add_action("init", [$this->_ajax, "registerAjax"]);
            add_action("rest_api_init", [$this->_api, "registerApi"]);
            $this->_frontendPage->registerFrontendRule($this->id,$this->id,'');

        }
    }

    public function registerAjax(){
        $menus =[
            ["menu_slug" => "pay/order/init"],
            ["menu_slug" => "pay/order/index"],
            ["menu_slug" => "pay/order/create"],
            ["menu_slug" => "pay/order/view"],
            ["menu_slug" => "pay/order/update"],
            ["menu_slug" => "pay/order/delete"],
            ["menu_slug" => "pay/order/deletes"],

            ["menu_slug" => "pay/reflect/init"],
            ["menu_slug" => "pay/reflect/index"],
            ["menu_slug" => "pay/reflect/create"],
            ["menu_slug" => "pay/reflect/view"],
            ["menu_slug" => "pay/reflect/update"],
            ["menu_slug" => "pay/reflect/delete"],
            ["menu_slug" => "pay/reflect/deletes"]
        ];
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction();
        }
    }

    /**
     * 注册RestfulApi
     */
    public function registerApi()
    {
        App::addApi($this->id);
    }

    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect()
    {
        Yii::$app->templateRedirect($this->id,'frontend');
    }

}