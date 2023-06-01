<?php

namespace crud\components;

use Yii;
use Exception;
use backend\web\App;
use yii\base\Component;
use crud\models\AjaxAction;

/**
 *
 */
class AjaxComponent extends Component
{

    // +----------------------------------------------------------------------
    // ｜Ajax、RestfulApi、路由配置、解析规则，注册、配置和回调
    // +----------------------------------------------------------------------
    /**
     * 注册控制器ajax操作
     */
    public function registerAjax()
    {
        /** @var App $app */
        $app = Yii::$app;
        $menus =  $app->params["menus"];
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction();
        }
    }
    /**
     * ajax和回调
     */
    public function renderAjax()
    {
        /** @var App $app */
        $app = Yii::$app;
        try {
            $request = Yii::$app->request;
            $query =  $request->get();
            if(isset($query['action']) and !empty($query['action'])){
                $route = $query['action'];
                unset($query['action']);
            }else{
                $data = $request->post();
                $route = $data['action'];
                unset($data['action']);
            }

            if ( $app->_route->checkAdminPageRoute($route, $moduleId)) {
                if (empty($moduleId)) {
                    $data = $app->runAction($route, $query);
                } else {
                    $data = $app->getModule($moduleId)->runAction($route, $query);
                }
            }
        } catch (Exception $exception) {
            header('Content-Type: application/json');
            $data = json_encode([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
                "file" => $exception->getFile()
            ]);
        }
        if (!empty($data)) {
            exit($data);
        }
    }

}