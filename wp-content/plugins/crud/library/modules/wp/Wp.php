<?php


namespace crud\modules\wp;

use Yii;
use yii\base\Module;
use yii\db\Exception;
use yii\debug\panels\DumpPanel;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
use yii\console\Application as ConsoleApplication;



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
            // +----------------------------------------------------------------------
            // ｜配置wp模块路由注册到前台和公共api路由
            // +----------------------------------------------------------------------
            // ｜http://youdomain.com/crud/ => wp/index/index
            // ｜http://youdomain.com/crud/<controller>/ => wp/<controller>/index
            // ｜http://youdomain.com/crud/<controller>/<action>/ => wp/<controller>/<action>
            // ｜http://youdomain.com/crud/<controller>/<action>/<id>/ => wp/<controller>/<action>/<id>
            add_action('init', function () {
                add_rewrite_rule("^crud$",
                    'index.php?crud=index/index', "top");

                add_rewrite_rule("^crud/([\w]+)$",
                    'index.php?crud=$matches[1]/index', "top");

                add_rewrite_rule("^crud/([\w]+)/([\w]+)$",
                    'index.php?crud=$matches[1]/$matches[2]', "top");

                add_rewrite_rule("^crud/([\w]+)/([\w]+)/([0-9]+)$",
                    'index.php?crud=$matches[1]/$matches[2]&id=$matches[3]', "top");
            });
            add_filter('query_vars', function ($public_query_vars) {
                $public_query_vars[] = 'crud';
                $public_query_vars[] = 'id';

                return $public_query_vars;
            });
            add_action("template_redirect", [$this, "templateRedirect"]);
            // +----------------------------------------------------------------------
            // ｜将yii\web\View事件挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("wp_head",[$this,"statistics"]);
            add_action("get_template_part_loop",[$this,"wpInit"]);

            add_action("wp_head",[Yii::$app,"registerCsrfMetaTags"]);
            add_action("wp_head",[Yii::$app,"head"]);
            add_action("wp_body_open",[Yii::$app,"beginBody"]);
            add_action("wp_footer",[Yii::$app,"endBody"]);
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
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['crud']) and !empty($query_vars['crud'])) {
            $route = $query_vars['crud'];
            $params = $query_vars;
            $module = Yii::$app->getModule('wp');
            $response = Yii::$app->response;
            $response->format = 'html';
            $response->setStatusCode(200);
            unset($query_vars['crud']);
            if ($this->checkWpRoute($route)) {
                $response->data = $module->runAction($route, $params);
            } else {
                $response->data = $module->runAction("index/error", []);
            }
            $response->send();
            exit();
        }
    }

    /**
     * 向前台注册全局aeesets
     */
    public function wpInit(){
        try {
            $this->runAction('index/init');
        } catch (InvalidRouteException $e) {
        }
    }

    /**
     * 访问量统计
     */
    public function statistics(){
        Yii::$app->crawlers->auto();
    }

    /**
     * 检查某一个模块路由是否存在
     *
     * @param $route
     * @param string $moduleId
     *
     * @return bool
     */
    private function checkWpRoute($route, $moduleId = 'wp')
    {
        $str = explode('/', $route);
        $count = count($str);
        $controllerId = $str[$count - 2];
        unset($str[$count - 2]);
        $actionId = $str[$count - 1];
        unset($str[$count - 1]);
        $namespace = trim(join("\\", $str));
        $controllerNamespace = "crud\modules\\" . $moduleId . "\controllers\\" .
            ($namespace != "" ? $namespace . "\\" : "") .
            ucfirst($controllerId) . "Controller";
        $actionName = 'action' . ucfirst($actionId);
        return Yii::$app->checkRoute($controllerNamespace, $actionName);
    }
}