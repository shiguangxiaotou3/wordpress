<?php
namespace crud\modules\wp;

use Yii;
use yii\base\Module;
use yii\db\Exception;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\debug\panels\DumpPanel;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
use yii\console\Application as ConsoleApplication;
use crud\widgets\RegisterHighlightAssetWidget;
/**
 * Class Wp
 *
 * @package crud\modules\wp
 */
class Wp extends Module implements BootstrapInterface
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
        parent::init();
        $this->layout ='webslides';
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
        // 请不要忽略$app类名称检查的检查，因为console应用也会调用引导方法
        if ($app instanceof Application) {

            Yii::$app->route('wp','crud');
            // +----------------------------------------------------------------------
            // ｜将yii\web\View事件挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("get_template_part_loop",[$this,"wpInit"]);
        }
        // 控制台应用引导 yii\console\Application
        if ($app instanceof ConsoleApplication) {

        }
    }

    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect()
    {
        Yii::$app->templateRedirect('wp','crud','');
    }

    /**
     * 向前台注册全局aeesets
     */
    public function wpInit(){
        $wechat = Yii::$app->subscription;
        RegisterHighlightAssetWidget::widget();
        $wechat->share();
    }

}