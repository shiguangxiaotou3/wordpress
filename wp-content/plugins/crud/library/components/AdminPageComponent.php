<?php

namespace crud\components;

use Yii;
use Exception;
use backend\web\App;
use crud\models\Menu;
use yii\base\Component;
use yii\base\InvalidRouteException;
class AdminPageComponent extends Component
{

    /**
     * 注册菜单和页面
     *
     * @param string $moduleId
     */
    public function registerPage($moduleId = '')
    {
        /** @var App $app */
        $app = Yii::$app;
        if (empty($moduleId)) {
            $menus = $app->params["menus"];
        } else {
            $module = Yii::$app->getModule($moduleId);
            $menus = $module->params["menus"];
        }

        foreach ($menus as $menu) {
            $menuModel = new Menu($menu);
            $menuModel->registerMenu();
        }
    }

    /**
     * 调用控制器显示视图
     * @throws InvalidRouteException
     */
    public function renderView()
    {
        /** @var App $app */
        $app = Yii::$app;
        $request =  $app->request;
        $query = $request->queryParams;
        $route = $query["page"];
        unset($query['page']);
        if ($app->_route->checkAdminPageRoute($route, $moduleId)) {
            try {
                if (empty($moduleId)) {
                    $data = $app->runAction($route, $query);
                } else {
                    $data = $app->getModule($moduleId)->runAction($route, $query);
                }

            } catch (Exception $exception) {
                $data =  $app->errorHandler->wpAdminRenderException($exception);
            }
        } else {
            $data = $app->runAction("index/error", new  Exception('找不到路由' . $route));
        }
        if (!empty($data)) {
            $app->response->data = $data;
            $app->response->send();
        }
    }

}