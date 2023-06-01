<?php

namespace crud\components;

use Yii;
use backend\web\App;
use yii\base\Component;
class RouteComponents extends Component
{

    /**
     * 检查后台页面路由是否存在
     *
     * @param $route
     * @param $moduleId
     * @return bool
     */
    public function checkAdminPageRoute(&$route, &$moduleId = '')
    {
        // +----------------------------------------------------------------------
        // | 未启用模块情况
        // | index => backend\controllers\IndexController::actionIndex
        // ｜index/test =>backend\controllers\IndexController::actionTest
        // ｜test/test/test =>backend\controllers\test\TestController::actionTest
        // ｜启用模块情况
        // | wp => crud\modules\wp\controllers\IndexController::actionIndex
        // ｜wp/index => backend\controllers\IndexController::actionIndex
        // | wp/index/test => crud\modules\wp\controllers\IndexController::actionTest
        // | wp/test/index/index => crud\modules\wp\controllers\test\IndexController::actionIndex
        // +----------------------------------------------------------------------
        /** @var App $app */
        $app = Yii::$app;
        $arr = explode('/', $route);
        $count = count($arr);
        $modules =array_keys($app->modules);
        $is_module = in_array($arr[0], $modules);
        if ($is_module) {
            $moduleId = $arr[0];
            $module = Yii::$app->getModule($moduleId);
            $route = trim(str_replace($moduleId.'/', "", $route), "/");
            switch ($count) {
                case 1:
                    $controllerNamespace = $module->controllerNamespace.'\\IndexController';
                    $actionName = "actionIndex";
                    break;
                case 2:
                    $controllerNamespace = $module->controllerNamespace.'\\' . toScoreUnder(ucfirst($arr[1]) ,'-') . 'Controller';
                    $actionName = "actionIndex";
                    break;
                case 3:
                    $controllerNamespace = $module->controllerNamespace.'\\' . toScoreUnder(ucfirst($arr[1]),'-') . 'Controller';
                    $actionName = "action" .toScoreUnder( ucfirst($arr[2]),'-');
                    break;
                default:
                    unset($arr[0]);
                    $controllerId = $arr[$count - 2];
                    unset($arr[$count - 2]);
                    $actionId = $arr[$count - 1];
                    unset($arr[$count - 1]);
                    $namespace = trim(join("\\", $arr));
                    $controllerNamespace = $module->controllerNamespace.'\\' .
                        ($namespace != "" ? $namespace . "\\" : "") . ucfirst($controllerId) . 'Controller';
                    $actionName = "action" .toScoreUnder( ucfirst($actionId),'-');
            }

        } else {
            switch ($count) {
                case 1:
                    $controllerNamespace = $app->controllerNamespace.'\\' . ucfirst($arr[0]) . "Controller";
                    $actionName = "actionIndex";
                    break;
                case 2:
                    $controllerNamespace = $app->controllerNamespace.'\\' . ucfirst($arr[0]) . "Controller";
                    $actionName = "action" . ucfirst($arr[1]);
                    break;
                default:
                    $controllerId = $arr[$count - 2];
                    unset($arr[$count - 2]);
                    $actionId = $arr[$count - 1];
                    unset($arr[$count - 1]);
                    $namespace = trim(join("\\", $arr));
                    $controllerNamespace =$app->controllerNamespace.'\\' .
                        ($namespace != "" ? $namespace . "\\" : "")
                        . ucfirst($controllerId) . 'Controller';
                    $actionName = "action" . ucfirst($actionId);
            }
        }
        return $this->checkRoute($controllerNamespace, $actionName);
    }
    /**
     * 检查api路由
     *
     * @param $controller
     * @param $action
     * @param $route
     * @param $moduleId
     *
     * @return bool
     */
    public function checkApiRoute(&$moduleId, $controller, $action, &$route)
    {
        /** @var App $app */
        $app = Yii::$app;
        $modules = array_keys($app->modules);
        $controller = empty($controller) ? 'index' : $controller;
        $action = empty($action) ? 'index' : $action;
        if (empty($moduleId)) {
            if (in_array($controller, $modules)) {
                $moduleId = $controller;
                $controller = $action;
                $route = "api/$controller/$action";
                $defaultControllerNamespace = Yii::$app->getModule($moduleId)->controllerNamespace;
            } else {
                $route = "api/$controller/$action";
                $defaultControllerNamespace = Yii::$app->controllerNamespace;
            }

        } else {
            $route = "api/$controller/$action";
            $defaultControllerNamespace = Yii::$app->getModule($moduleId)->controllerNamespace;
        }

        $str = explode('/', $route);
        if (count($str) == 3) {
            $controllerNamespace = $defaultControllerNamespace . "\\" . $str[0] . '\\' .toScoreUnder( ucfirst($str[1]),"-") . "Controller";
            $actionName = 'action' . toScoreUnder(ucfirst($str[2]), "-");
        } else {
            $controllerNamespace = $defaultControllerNamespace . "\\". toScoreUnder(ucfirst($str[2]),"-") . "Controller";
            $actionName = 'action' . toScoreUnder(ucfirst($str[3]), "-");
        }
        return $this->checkRoute($controllerNamespace, $actionName);

    }

    /**
     * 检查路由是否存在
     *
     * @param $controllerNamespace
     * @param $actionName
     *
     * @return bool
     */
    public function checkRoute($controllerNamespace, $actionName)
    {

        if (!class_exists($controllerNamespace)) {
            return false;
        }
        if (!method_exists($controllerNamespace, $actionName)) {
            return false;
        }
        return true;
    }
}