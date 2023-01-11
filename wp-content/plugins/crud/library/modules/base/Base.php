<?php


namespace crud\modules\base;

use Yii;
use yii\base\Module;
use crud\models\Menu;
use yii\web\Application;
use crud\models\Settings;
use crud\models\AjaxAction;
use crud\Base  as BaseModel;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use crud\modules\ModuleImplements;
use yii\base\InvalidRouteException;





class Base extends Module  implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $id ='base';

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\base\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
        parent::init();
        $this->layout =false;
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
            // ｜后台页面、设置、菜单，挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("admin_init", [$this, "registerSettings"]);
            add_action("admin_menu", [$this, "registerPage"]);

            // +----------------------------------------------------------------------
            // ｜Ajax、RestfulApi、路由配置、解析规则，挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("admin_init", [$this, "registerAjax"]);
            add_action("rest_api_init", [$this,"registerRestfulApi"]);

            // +----------------------------------------------------------------------
            // ｜将yii\web\View事件挂载到wordpress钩子中
            // +----------------------------------------------------------------------
            add_action("admin_init", [$this, "beginPage"]);
            add_action("admin_head",[$this,"registerCsrfMetaTags"]);
            add_action("admin_head",[$this,"head"]);
            add_action("admin_body_open",[$this,"beginBody"]);
            add_action("admin_footer",[$this,"endBody"]);
            add_action("admin_footer",[$this,"endPage"]);
        }
    }
    // +----------------------------------------------------------------------
    // ｜后台页面、设置、菜单等，注册和回调
    // +----------------------------------------------------------------------
    /**
     * 注册设置
     */
    public function registerSettings(){
        $settings = $this->params["settings"];
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册菜单和页面
     */
    public function registerPage(){
        $menus= $this->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new Menu($menu);
            $menuModel->registerMenu($this);
        }
    }

    /**
     * 调用控制器显示视图
     */
    public function renderView(){
        $request = Yii::$app->request;
        $query =$request->queryParams;
        if($request->isAjax){
            if($request->isGet){
                $action =$request->get("action","");
            }else{
                $action = $request->post("action","");
            }
            unset( $query['action']);
            BaseModel::sendJson($this->runAction($action));
        }else{
            try{
                $action= $query["page"];
                unset( $query['page']);
                BaseModel::sendHtml($this->runAction($action,$query));
            }catch (\Exception $exception){
                echo $action;
                die();
                Base::sendHtml($this->runAction("index/error",$query));
            }

        }
    }

    // +----------------------------------------------------------------------
    // ｜Ajax、RestfulApi、路由配置、解析规则，注册、配置和回调
    // +----------------------------------------------------------------------
    /**
     * 注册控制器ajax操作
     */
    public function registerAjax(){
        $menus= $this->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
        }
    }

    /**
     * 注册RestfulApi
     */
    public function registerRestfulApi(){
        /**
         *  * - `'PUT,PATCH users/<id>' => 'user/update'`: update a user
         * - `'DELETE users/<id>' => 'user/delete'`: delete a user
         * - `'GET,HEAD users/<id>' => 'user/view'`: return the details/overview/options of a user
         * - `'POST users' => 'user/create'`: create a new user
         * - `'GET,HEAD users' => 'user/index'`: return a list/overview/options of users
         * - `'users/<id>' => 'user/options'`: process all unhandled verbs of a user
         * - `'users' => 'user/options'`: process all unhandled verbs of user collection
         */

        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "PUT,PATCH",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "DELETE",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "POST",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<controller>[\w]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        // 模块默认控制器
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "PUT,PATCH",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "DELETE",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "POST",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "GET,HEAD",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("crud", "api/(?P<module>[\w]+)/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
            'methods' => "OPTIONS",
            'callback' => [$this, "renderApi"],
            'permission_callback' => function() { return ''; },
        ]);

    }

    /**
     * 将RestfulApi解析到指定的控制器
     * @param $request
     * @throws InvalidRouteException
     */
    public function renderApi($request){
        list($route ,$params) = $this->getRoute($request);
        try {
            $data = $this->runAction($route ,$params);
            Base::sendJson(   $data  );
        }  catch  (Exception $exception){
            Base::sendJson(
                [
                    'code'=>$exception->getCode(),
                    'message'=>$exception->getMessage(),
                    'trace'=>$exception->getTrace(),
                    "file"=>$exception->getFile()
                ]
            );
        }
    }

    /**
     * 通过请求，获取对应的控制器id
     * @param $request
     * @return array
     */
    public function getRoute($request){
        $params = $request->get_params();
        $module = $controller = $id ='';
        if (isset($params['id'])) {
            $id = $params["id"];
        }
        $action = $this->getMethod($id);

        if (isset($params['module'])){
            $module = $params['module'];
            unset($params['module']);
        }
        if (isset($params['controller'])) {
            $controller = $params["controller"];
            unset($params['controller']);
        }

        if(empty($module) && $this->is_module($controller)){
            $route = $controller."/api/index/".$action;
        }elseif(!empty($module) and !empty($controller) and !$this->is_module($controller)){
            $route =$module."/api/".$controller."/".$action;
        }else{
            $route ="api/".$controller.'/'.$action;
        }
        return [$route,$params];
    }

    /**
     * @param $id
     * @return string
     */
    public function getMethod($id){
        $method = Yii::$app->request->method;
        switch ($method) {
            case 'GET':
            case 'HEAD':
                $action = empty($id) ? "index" : "view";
                break;
            case 'POST':
                $action = "create";
                break;
            case 'PATCH':
            case 'PUT':
                $action = "update";
                break;
            case 'DELETE':
                $action = "delete";
                break;
            case 'OPTIONS':
                $action = "options";
            default:
                $action = "index";
        }
        return $action;
    }

    // +----------------------------------------------------------------------
    // ｜yii\web\View事件的回调(用于在视图中加载前端资源包)
    // +----------------------------------------------------------------------
    public function beginPage(){
        Yii::$app->view->beginPage();
    }
    public function registerCsrfMetaTags(){
        echo  Yii::$app->view->registerCsrfMetaTags();
    }
    public function head(){
        Yii::$app->view->head();
    }
    public function beginBody(){
        Yii::$app->view->beginBody();
    }
    public function endBody(){
        Yii::$app->view->endBody();
    }
    public function endPage(){
        $controller =  Yii::$app->controller;
        if(isset($controller) and !empty($controller)){
            $controller->getView()->endPage();
        }
    }
}