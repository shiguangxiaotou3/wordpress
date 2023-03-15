<?php
namespace crud\components;

use Yii;
use yii\base\Component;
/***
 * Class Route
 * @package crud\components
 */
class Route extends Component
{

    public function checkAdminPageRoute(){
        $request = $this->request;
        $query = $request->queryParams;
        $route = $query["page"];

        $arr = explode('/', $route);
        $count = count($arr);
        $modules = array_keys(Yii::$app->modules);
        $is_module = in_array($arr[0], $modules);
        if ($is_module) {
            $moduleId = $arr[0];
            $route = trim( str_replace($moduleId,"",$route),"/");
            $defaultControllerNamespace = Yii::$app->getModule($moduleId);
            switch ($count) {
                case 1:
                    $controllerNamespace = 'crud\modules\\' . $moduleId . '\controllers\IndexController';
                    $actionName = "actionIndex";
                    break;
                case 2:
                    $controllerNamespace = 'crud\modules\\' . $moduleId . '\controllers\\' . ucfirst($arr[1]) . 'Controller';
                    $actionName = "actionIndex";
                    break;
                case 3:
                    $controllerNamespace = 'crud\modules\\' . $moduleId . '\controllers\\' . ucfirst($arr[1]) . 'Controller';
                    $actionName = "action" . ucfirst($arr[2]);
                    break;
                default:
                    unset($arr[0]);
                    $controllerId = $arr[$count - 2];
                    unset($arr[$count - 2]);
                    $actionId = $arr[$count - 1];
                    unset($arr[$count - 1]);
                    $namespace = trim(join("\\", $arr));
                    $controllerNamespace = 'crud\modules\\' . $moduleId . '\controllers\\' .
                        ($namespace != "" ? $namespace . "\\" : "") . ucfirst($controllerId) . 'Controller';
                    $actionName = "action" . ucfirst($actionId);
            }

        } else {
            switch ($count) {
                case 1:
                    $controllerNamespace = 'backend\controllers\\' . ucfirst($arr[0]) . "Controller";
                    $actionName = "actionIndex";
                    break;
                case 2:
                    $controllerNamespace = 'backend\controllers\\' . ucfirst($arr[0]) . "Controller";
                    $actionName = "action" . ucfirst($arr[1]);
                    break;
                default:
                    $controllerId = $arr[$count - 2];
                    unset($arr[$count - 2]);
                    $actionId = $arr[$count - 1];
                    unset($arr[$count - 1]);
                    $namespace = trim(join("\\", $arr));
                    $controllerNamespace = 'backend\controllers\\' .
                        ($namespace != "" ? $namespace . "\\" : "")
                        . ucfirst($controllerId) . 'Controller';
                    $actionName = "action" . ucfirst($actionId);
            }
        }
    }
}