<?php

namespace backend\web;

use Yii;
use crud\Base;
use crud\models\Menu;
use crud\modules\wp\Wp;
use yii\web\Application;
use crud\models\Settings;
use crud\modules\ads\Ads;
use crud\modules\seo\Seo;
use crud\modules\crud\Crud;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use crud\modules\editor\Editor;
use crud\modules\alipay\AliPay;
use crud\modules\server\Server;
use crud\modules\wechat\Wechat;
use crud\modules\applets\Applets;
use yii\base\InvalidRouteException;
use yii\base\InvalidConfigException;
use crud\modules\translate\Translate;
use crud\modules\base\Base as BaseModule;
use PHPMailer\PHPMailer\PHPMailer as SMTP;


/**
 * App对象基类
 * @property-read yii\web\Application $app
 * @package crud\backend\web
 */
class App extends  Application {

    /**
     * 创建app对象
     * App constructor.
     * @throws InvalidConfigException
     */
    public function __construct(){
        require __DIR__ . '/../config/bootstrap.php';
        $config = ArrayHelper::merge(
            require __DIR__ . '/../../common/config/main.php',
            require __DIR__ . '/../../common/config/main-local.php',
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php',
            $this->loadModulesConfig()
        );
        parent::__construct($config);
    }

    /**
     * 引导模块初始化
     *
     * backend\web\App初始化之后,执行所配置模块的init()方法
     * 例如：crud\modules\wp\Wp::init()方法优先级大于backend\web\App::run()方法
     * 请不要在init()调用global $crud; 此时初始化未完成
     * 请不要将模块id和组件id重名
     * @return string[]
     */
    public static function loadModulesConfig(){
        // +----------------------------------------------------------------------
        // ｜子模块引导配置
        // +----------------------------------------------------------------------
        // ｜App实例化时候会根据bootstrap配置项调用模块的bootstrap(),引导wordpress挂载
        // ｜例如:['bootstrap'=>['wp']] =>crud\modules\wp\Wp::bootstrap()
        // +----------------------------------------------------------------------
        $config = [
            'bootstrap'=>['wechat','wp'],
        ];
        return ArrayHelper::merge(
            BaseModule::config(),
            Wp::config(),
            Wechat::config(),
            Ads::config(),
            AliPay::config(),
            Editor::config(),
            Seo::config(),
            Server::config(),
            Translate::config(),
            Applets::config(),
            Crud::config(),
            $config
        );
    }

    /**
     * 核心:将Yii2操作、事件等挂载到wordpress钩子上
     */
    public function run(){
        // +----------------------------------------------------------------------
        // ｜配置wp模块和公共api路由
        // +----------------------------------------------------------------------
        // ｜http://youdomain.com/crud/ => wp/index/index
        // ｜http://youdomain.com/crud/<controller>/ => wp/<controller>/index
        // ｜http://youdomain.com/crud/<controller>/<action>/ => wp/<controller>/<action>
        // ｜http://youdomain.com/crud/<controller>/<action>/<id>/ => wp/<controller>/<action>/<id>
        add_action('init', function (){
            add_rewrite_rule('^crud[/]?$',
                'index.php?crud=index/index','top');

            add_rewrite_rule('^crud[/]([\w]+)[/]?$',
                'index.php?crud=$matches[1]/index','top');

            add_rewrite_rule('^crud[/]([\w]+)/([\w]+)[/]?$',
                'index.php?crud=$matches[1]/$matches[2]','top');

            add_rewrite_rule('^crud[/]([\w]+)[/]([\w]+)[/]([0-9]+)[/]?$',
                'index.php?crud=$matches[1]/$matches[2]&id=$matches[3]','top');
        });
        add_filter('query_vars',function ($public_query_vars){
            $public_query_vars[] = 'crud';
            $public_query_vars[] = 'id';
            $public_query_vars[] = 'api';
            return $public_query_vars;
        });
        add_action("template_redirect", [$this,"templateRedirect"]);

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

        // +----------------------------------------------------------------------
        // ｜配置邮箱
        // +----------------------------------------------------------------------
        add_action('phpmailer_init',[$this,"smtp"]);

        // +----------------------------------------------------------------------
        // ｜过滤评论
        // +----------------------------------------------------------------------
        add_action('preprocess_comment',[$this,'preprocessComment']);

        // +----------------------------------------------------------------------
        // ｜静止自动更新
        // +----------------------------------------------------------------------
        add_filter('pre_site_transient_update_core',    function(){return null;}); // 关闭核心提示
        add_filter('pre_site_transient_update_plugins',  function(){return null;}); // 关闭插件提示
        add_filter('pre_site_transient_update_themes',   function(){return null;}); // 关闭主题提示
        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        remove_action('admin_init', '_maybe_update_themes');

    }

    // +----------------------------------------------------------------------
    // ｜后台页面、设置、菜单等，注册和回调
    // +----------------------------------------------------------------------
    /**
     * 注册设置
     * @param string $moduleId
     */
    public function registerSettings($moduleId=''){
        if(empty($moduleId)){
            $settings= $this->params["settings"];
        }else{
            $module = Yii::$app->getModule($moduleId);
            $settings=  $module->params["settings"];
        }
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册菜单和页面
     * @param string $moduleId
     */
    public function registerPage($moduleId=''){
        if(empty($moduleId)){
            $menus= $this->params["menus"] ;
        }else{
            $module = Yii::$app->getModule($moduleId);
            $menus=  $module->params["menus"] ;
        }

        foreach ($menus as $menu) {
            $menuModel = new Menu($menu);
            $menuModel->registerMenu($this);
        }
    }

    /**
     * 调用控制器显示视图
     * @throws InvalidRouteException
     */
    public function renderView(){
        $request = $this->request;
        $query =$request->queryParams;
        if($request->isAjax){
            if($request->isGet){
                $action =$request->get("action","");
            }else{
                $action = $request->post("action","");
            }
            unset( $query['action']);
            Base::sendJson($this->runAction($action));
        }else{
            try{
                $action= $query["page"];
                unset( $query['page']);
                echo $this->runAction($action,$query);
            }catch (\Exception $exception){
                Base::sendHtml($this->runAction("index/error",$query));
//                die();
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

        // 模块默认控制器
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


    }

    /**
     * 将RestfulApi解析到指定的控制器
     * @param $request
     * @throws InvalidRouteException
     */
    public function renderApi($request){
        // +----------------------------------------------------------------------
        // ｜获取操作名称 $route,$params
        // +----------------------------------------------------------------------
        $module = $controller = $id = '';
        $method = Yii::$app->request->method;
        $params = $request->get_params();
        // GET HEAD POST PATCH PUT DELETE OPTIONS
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
        // +----------------------------------------------------------------------
        // ｜获取路由$route,$params
        // +----------------------------------------------------------------------
        if (isset($params['id'])) {
            $id = $params["id"];
        }
        if (isset($params['module'])) {
            $module = $params['module'];
            unset($params['module']);
        }
        if (isset($params['controller'])) {
            $controller = $params["controller"];
            unset($params['controller']);
        }
        $modules = array_keys(Yii::$app->modules);
        if (empty($module) and !empty($controller) and in_array($controller, $modules)) {
            $route = $controller . "/api/index/" . $action;
        } elseif (!empty($module) and !empty($controller) and !in_array($controller, $modules)) {
            $route = $module . "/api/" . $controller . "/" . $action;
        } else {
            $route = 'api/index/' . $action;
        }
        // +----------------------------------------------------------------------
        // ｜验证控制和方法是否存在
        // +----------------------------------------------------------------------
        $str = explode('/', $route);
        if (count($str) == 3) {
            $controllerNamespace = "backend\controllers\\" . $str[0] . '\\' . ucfirst($str[1]) . "Controller";
            $actionName = 'action' . ucfirst($str[2]);
        } else {
            $controllerNamespace = "crud\modules\\" . $str[0] . "\controllers\api\\" . ucfirst($str[2]) . "Controller";
            $actionName = 'action' . ucfirst($str[3]);
        }
        if (!class_exists($controllerNamespace)) {
             Base::sendJson(['code' => 0, 'message' => $controllerNamespace . ":类不存在",]);
        }
        if (!method_exists($controllerNamespace, $actionName)) {
            Base::sendJson(['code' => 0, 'message' => $controllerNamespace . "::" . $action . "()不存在",]);
        }
        // +----------------------------------------------------------------------
        // ｜执行控制器
        // +----------------------------------------------------------------------
        try {
            $data = $this->runAction($route, $params);
            Base::sendJson(['code' => 1, 'message'=>"ok",'data' =>$data,"time"=>time()]);
        } catch (Exception $exception) {
            Base::sendJson([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
                "file" => $exception->getFile()
            ]);
        }
    }

    /**
     * 配置发送邮箱
     * @param SMTP $mail
     */
    public function smtp($mail){

        // 发件人呢称
        $mail->FromName = get_option('crud_group_mail_blogname','');
        // smtp 服务器地址
        $mail->Host = get_option('crud_group_mail_host',"smtp.qq.com");
        // 端口号
        $mail->Port =get_option('crud_group_mail_port',465);
        // 账户
        $mail->Username =get_option('crud_group_mail_username','');
        // 密码
        $mail->Password =get_option('crud_group_mail_password','');
        // 收件人
        $mail->From =get_option('crud_group_mail_username','');;
        $mail->SMTPAuth =true;
        $mail->SMTPSecure =get_option('crud_group_mail_encryption',"ssl");
        $mail->isSMTP();
    }

    // +----------------------------------------------------------------------
    // ｜yii\web\View事件的回调(用于在视图中加载前端资源包)
    // +----------------------------------------------------------------------
    public function beginPage(){
        $this->getView()->beginPage();
    }
    public function registerCsrfMetaTags(){
        echo $this->getView()->registerCsrfMetaTags();
    }
    public function head(){
        $this->getView()->head();
    }
    public function beginBody(){
        $this->getView()->beginBody();
    }
    public function endBody(){
        $this->getView()->endBody();
    }
    public function endPage(){
        $controller = $this->controller;
        if(isset($controller) and !empty($controller)){
            $controller->getView()->endPage();
        }
    }

    /**
     * 过滤评论
     */
    public function preprocessComment(){

    }

    /**
     * 显示前台页面
     * @throws InvalidRouteException
     */
    public function templateRedirect(){
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['crud']) and !empty($query_vars['crud'])) {
            dump($query_vars);
            die();
            $route=$query_vars['crud'];
            unset($query_vars['crud']);
            $params=$query_vars;
            $module =Yii::$app->getModule('wp');
            $response = Yii::$app->response;
            $response->format ='html';
            $response->setStatusCode(200);
            $response->data =$module->runAction($route,$params);
            exit($response->send());
        }
        if(isset($query_vars['api'])){
            dump($query_vars);
            die();
        }
    }

}
