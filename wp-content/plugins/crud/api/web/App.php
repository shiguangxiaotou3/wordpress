<?php
namespace api\web;

use Yii;
use yii\base\BaseObject;
use yii\web\Application;
use yii\helpers\ArrayHelper;

/**
 * Class App
 * @property-read $app
 * @package api\web
 */
class App extends  BaseObject {


    public $_api;
    public $namespace='crud/api';

    /**
     * App constructor.
     */
    public function __construct(){
        require __DIR__ . '/../config/bootstrap.php';
        $config = ArrayHelper::merge(
            require __DIR__ . '/../../common/config/main.php',
            require __DIR__ . '/../../common/config/main-local.php',
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php'
        );
        try {
            $this->_api = new Application($config);
        }catch (Exception $exception){
            self::exception($exception,debug_backtrace());
        }

    }

    /**
     * 挂载控制器
     */
    public function run(){
        // 创建api
        add_action("rest_api_init", [$this,"registerRestRoute"]);
    }

    /**
     * 获取app容器
     * @return Application
     */
    public function getApp(){
        if(isset($this->_api)){
            return ($this->_api->id !== 'api') ? self::__construct() :$this->_api;
        }else{
            return self::__construct();
        }
    }

    /**
     * 注册api
     */
    public function registerRestRoute(){
        $rules = [
            // 控制器
            "(?P<controller>[\w]+)",
            // 控制器/方法
            "(?P<controller>[\w]+)/(?P<action>[\w]+)",
            // 控制器/方法/id
//            "(?P<controller>[\w]+)/(?P<action>[\w]+)/(?P<id>[\d]+)",
            // 版本/控制器
//            "(?P<version>v1|v2)/(?P<controller>[\w]+)",
            // 版本/控制器/方法
//            "(?P<version>v1|v2)/(?P<controller>[\w]+)/(?P<action>[\w]+)",
            // 版本/控制器/方法/id
//            "(?P<version>v1|v2)/(?P<controller>[\w]+)/(?P<action>[\w]+)/(?P<id>[\d]+)"
        ];

        foreach ($rules as $rule) {
            register_rest_route($this->namespace, $rule, [
                'methods' => "GET, POST, PUT, PATCH, DELETE",
                'callback' => [$this, "renderApi"]
            ]);
        }

    }

    /**
     * 执行执行控制器
     * @param  $request WP_REST_Request
     * @throws \yii\base\InvalidRouteException
     */
    public function renderApi( $request){
        $params = $request->get_params();
        $version =( isset($params['version']) and !empty($params['version'])) ? $params['version'] : "";
        unset($params['version']);
        $controller = (isset($params['controller']) and !empty($params['controller']) )? $params['controller'] : "index";
        unset($params['controller']);
        $action = (isset($params['action']) and !empty($params['action'])) ? $params['action'] : "index";
        unset($params["action"]);
        try {
            $this->app->runAction($controller."/".$action,$params);
        }catch (Exception $exception){
            self::exception($exception,debug_backtrace(),"json");
        }
        https://www.shiguangxiaotou.com/wp-json/crud/api/wechat
    }

    /**
     * @param Exception $exception
     * @param $backtrace
     * @param string $type
     */
    public static function exception(Exception $exception, $backtrace, $type ="html"){
        $msg = $exception->getMessage();
        $code = $exception->getCode();
        header('Content-Type:application/json; charset=utf-8');
        $data = [
                'code' => $code,
                "msg" => $msg,
                "data" => $backtrace,
                "time"=>time()
            ];
        exit(json_encode($data, true));
    }

    public function send($data){
        $response = $this->app->response;
        rest_ensure_response();
    }
}