<?php

namespace backend\web;


use Yii;
use Exception;
use yii\web\Controller;
use crud\models\Menu;
use crud\models\Settings;
use yii\base\BaseObject;
use yii\web\Application;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use crud\widgets\WpTableWidget;


/**
 * Class App
 * @property-read Application $app
 * @package crud\backend\web
 */
class App extends  BaseObject {

    public $_admin;
    /**
     * @var Controller $_controller
     */
    public $_controller;

    /**
     * App constructor.
     */
    public function __construct(){
        require __DIR__ . '/../config/bootstrap.php';
        $config = ArrayHelper::merge(
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php'
        );
        try {
            $this->_admin = new Application($config);
        }catch (Exception $exception){
            self::exception($exception,debug_backtrace());
        }

    }

    /**
     * 获取app容器
     */
    public function getApp(){
        if(isset($this->_admin)){
            return ($this->_admin->id !== "backend") ?self::__construct() : $this->_admin ;
        }else{
            return self::__construct();
        }
    }


    /**
     * 挂载控制器
     */
    public function run(){
        // 将设置注册到特定的页面
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_init", [$this, "registerAjaxAction"]);

        // 注册菜单 = 也就是注册yii Controller
        add_action("admin_menu", [$this, "registerPage"]);

        // 将Yii2 视图事件挂载到wordpress钩子
        // 为资源包文件创建缓存快，
        add_action("admin_init", [$this, "beginPage"]);
        add_action("admin_head",[$this,"registerCsrfMetaTags"]);
        add_action("admin_head",[$this,"head"]);
        add_action("admin_body_open",[$this,"beginBody"]);
        add_action("admin_footer",[$this,"endBody"]);
        add_action("admin_footer",[$this,"endPage"]);
//        add_action("admin_print_footer_scripts",[$this,"endPage"]);
        add_action("rest_api_init", [$this,"registerRestRoute"]);
    }

    /**
     * 注册设置
     */
    public function registerSettings(){
        $settings = $this->app->params["settings"];
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册菜单和页面
     */
    public function registerPage(){
        $menus= $this->app->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new Menu($menu);
            $menuModel->registerMenu($this);
        }
    }

    /**
     * 调用控制器显示视图
     */
    public function renderView(){
        $request = $this->app->request;
        $query = $request->queryParams;
        $action= $query["page"];
        $config = ['index.php'];
        try {
            if (!in_array($action, $config)) {
                /** 注意: 此时返回的子视图文件html,前端资源包为写入
                 * 需要使用Yii::$app->view->endPage()方法写入前端资源包,
                 * wordpress的admin_print_footer_scripts钩子
                 * 自动回调$plugins->endPage()完成资源写入页面
                 */
                echo $this->app->runAction($action);
                $this->_controller = Yii::$app->controller;
            }else{
                return ;
            }
        } catch (Exception $exception) {
            self::exception($exception,debug_backtrace());
        }
    }

    /**
     * 注册ajax操作
     */
    public function registerAjaxAction(){
        $menus= $this->_admin->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
        }
    }

    /**
     * 执行ajax回调
     */
    public function renderAjax(){
        try{
            $request = $this->_admin->request;
            if($request->isAjax){
                if($request->isGet){
                    $action =$request->get("action","");
                }else{
                    $action = $request->post("action","");
                }
                $data = $this->app->runAction($action);
                $this->sendJson("请求成功",1,$data);
            }
        } catch (Exception $exception) {
            $data =[
                "code"=>$exception->getCode(),
                "file"=>$exception->getFile(),
                'line'=>$exception->getLine(),
                "message"=>$exception->getMessage(),
                "traceAsString"=>$exception->getTraceAsString(),
                "trace"=>$exception->getTrace(),
                "previous"=>$exception->getPrevious()
            ];
            $this->sendJson("失败",0,$data);
        }

    }

    /**------------------------------
     * 为视图定义资源包缓存快,将Yii2视图事件回调
     *------------------------------*/
    public function registerCsrfMetaTags(){echo $this->app->view->registerCsrfMetaTags();}
    public function beginPage(){$this->app->view->beginPage();}
    public function head(){$this->app->view->head();}
    public function beginBody(){$this->app->view->beginBody();}
    public function endBody(){$this->app->view->endBody();}
    public function endPage(){ isset($this->_controller) ?$this->_controller->getView()->endPage():""; }

    /**
     * @param Exception $exception
     * @param $backtrace
     * @param string $type
     */
    public static function exception(Exception $exception, $backtrace, $type ="html"){
        $msg = $exception->getMessage();
        $code = $exception->getCode();
        $file = $exception->getFile().":".$exception->getLine();
        if ($type == "html") {
            $str = "<h1> Error: $code </h1>";
            $str .= "<p>$msg</p>";
            $str .="<p>$file</p>";
            $str .= WpTableWidget::widget([
                "columns" => [
                    ["field" => "file", "title" => "文件"],
                    ["field" => "line", "title" => "行号"],
                    ["field" => "function", "title" => "函数名"],
                    ["field" => "class", "title" => "类名"],
                    ["field" => "args", "title" => "参数"]
                ],
                'data' => $backtrace]);
            echo $str;
        } else {
            $json = [
                'code' => $code,
                "msg" => $msg,
                "data" => $backtrace
            ];
            echo json_encode($json, true);
        }
        exit();
    }

    /**
     * @param $message
     * @param $code
     * @param string $data
     */
    public function sendJson($message, $code, $data = ""){
        $tmp =[
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,
            'time'=>time(),
        ];
        header('Content-Type:application/json; charset=utf-8');
        exit(json_encode($tmp, true));
    }

    public function registerRestRoute(){
        register_rest_route("ads/api", "update", [
            'methods' => "GET, POST, PUT, PATCH, DELETE",
            'callback' => [$this, "update"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("ads/api", "updatekey", [
            'methods' => "GET, POST, PUT, PATCH, DELETE",
            'callback' => [$this, "UpdateKey"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("ads/api", "getAdGroups", [
            'methods' => "GET, POST, PUT, PATCH, DELETE",
            'callback' => [$this, "GetAdGroups"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("ads/api", "getKeyword", [
            'methods' => "GET, POST, PUT, PATCH, DELETE",
            'callback' => [$this, "GetKeyWord"],
            'permission_callback' => function() { return ''; },
        ]);
        register_rest_route("ads/api", "updateKeyword", [
            'methods' => "GET, POST, PUT, PATCH, DELETE",
            'callback' => [$this, "UpdateKeyWord"],
            'permission_callback' => function() { return ''; },
        ]);
    }

    public function GetAdGroups(){
        $this->app->runAction("ads/get-ad-groups-by-campaign-id");
    }

    public function GetKeyWord(){
        $this->app->runAction("ads/key-word");
    }
    public function update(){
        $this->app->runAction("ads/update");
    }
    public function UpdateKey(){
        $this->app->runAction("ads/update-key");
    }
    public function UpdateKeyWord(){
        $this->app->runAction("ads/update-key-word-one");
    }

}
