<?php

namespace backend\web;

use Yii;
use Exception;
use yii\web\View;
use crud\models\Menu;
use crud\modules\wp\Wp;
use yii\web\Application;
use crud\modules\sms\Sms;
use crud\modules\pay\Pay;
use crud\models\Settings;
use crud\models\AjaxAction;
use yii\helpers\ArrayHelper;
use crud\modules\market\Market;
use crud\modules\wechat\Wechat;
use yii\gii\Module as GiiModule;
use crud\modules\applets\Applets;
use yii\base\InvalidRouteException;
use yii\base\InvalidConfigException;
use crud\modules\translate\Translate;
use crud\modules\base\Base as BaseModule;
use PHPMailer\PHPMailer\PHPMailer as SMTP;

/**
 * App对象基类
 *
 *  header("Content-Type:application/json;charset=UTF-8;");
 *
 * @property-read yii\web\Application $app
 * @package crud\backend\web
 */
class App extends Application
{

    /**
     * 创建app对象
     * App constructor.
     * @throws InvalidConfigException
     */
    public function __construct()
    {
        // +----------------------------------------------------------------------
        // ｜ 应用初始化
        // +----------------------------------------------------------------------
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
    public static function loadModulesConfig()
    {
        // +----------------------------------------------------------------------
        // ｜子模块引导配置
        // +----------------------------------------------------------------------
        // ｜App实例化时候会根据bootstrap配置项调用模块的bootstrap(),引导wordpress挂载
        // ｜例如:['bootstrap'=>['wp']] =>crud\modules\wp\Wp::bootstrap()
        // +----------------------------------------------------------------------
        // ｜特别说明
        // ｜子模块bootstrap()方法配置的wp钩子优先挂载backend\web\App::run()方法中配置的钩子
        // +----------------------------------------------------------------------
        return ArrayHelper::merge(
            [
                "bootstrap" => ["base", 'applets','pay', 'sms', "wechat", 'wp', 'market', 'gii'],
                'modules' => [
                    "gii" => [
                        'class' => GiiModule::class,
                    ],
                    'debug' => [
                        'class' => 'yii\debug\Module',
                        'allowedIPs' => ['119.98.223.254']
                    ]
                ]
            ],
            Applets::config(),
            BaseModule::config(),
            Pay::config(),
            Market::config(),
            Sms::config(),
            Translate::config(),
            Wechat::config(),
            Wp::config()
        );
    }

    /**
     * 核心:将Yii2操作、事件等挂载到wordpress钩子上
     */
    public function run()
    {
        // +----------------------------------------------------------------------
        // ｜后台页面、设置、菜单，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_menu", [$this, "registerPage"]);

        // +----------------------------------------------------------------------
        // ｜Ajax、RestfulApi、路由配置、解析规则，挂载到wordpress钩子中
        // +----------------------------------------------------------------------
        add_action("init", [$this, "registerAjax"]);
        add_action("rest_api_init", [$this, "registerApi"]);
        //add_action("wp_ajax_pay/index/remit",[$this,"renderAjaxTest"]);
        //add_action("wp_ajax_nopriv_pay/index/remit",[$this,"renderAjaxTest"]);

        // +----------------------------------------------------------------------
        // ｜配置邮箱
        // +----------------------------------------------------------------------
        add_action('phpmailer_init', [$this, "smtp"]);

        // +----------------------------------------------------------------------
        // ｜过滤评论
        // +----------------------------------------------------------------------
        add_action('preprocess_comment', [$this, 'preprocessComment']);

        // +----------------------------------------------------------------------
        // ｜在插件旁边显示设置按钮
        // +----------------------------------------------------------------------
        add_filter('plugin_action_links', [$this, 'addSettingsButton'], 10, 2);
        add_action('admin_print_scripts', [$this, 'printScripts']);
        add_action("admin_print_footer_scripts", [$this, "printFooterScripts"]);
        add_action("wp_footer", [$this, "printFooterScripts"]);
        // +----------------------------------------------------------------------
        // ｜静止自动更新
        // +----------------------------------------------------------------------
        //add_filter('pre_site_transient_update_core', function () {
        //    return null;
        //}); // 关闭核心提示
        //add_filter('pre_site_transient_update_plugins', function () {
        //    return null;
        //}); // 关闭插件提示
        //add_filter('pre_site_transient_update_themes', function () {
        //    return null;
        //}); // 关闭主题提示
        //remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        //remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        //remove_action('admin_init', '_maybe_update_themes');

        // +----------------------------------------------------------------------
        // ｜中国地区头像代理
        // +----------------------------------------------------------------------
        //add_filter('get_avatar', function ($avatar) {
        //    return str_replace([
        //        'https://www.gravatar.com',
        //        'https://0.gravatar.com',
        //        'https://1.gravatar.com',
        //        'https://2.gravatar.com',
        //        'https://secure.gravatar.com',
        //        'https://cn.gravatar.com',
        //    ], 'http://103.215.125.122', $avatar);
        //});

    }

    // +----------------------------------------------------------------------
    // ｜后台页面、设置、菜单等，注册和回调
    // +----------------------------------------------------------------------
    /**
     * 注册设置
     *
     * @param string $moduleId
     */
    public function registerSettings($moduleId = '')
    {
        if (empty($moduleId)) {
            $settings = $this->params["settings"];
        } else {
            $module = Yii::$app->getModule($moduleId);
            $settings = $module->params["settings"];
        }
        foreach ($settings as $setting) {
            $option = new Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册菜单和页面
     *
     * @param string $moduleId
     */
    public function registerPage($moduleId = '')
    {
        if (empty($moduleId)) {
            $menus = $this->params["menus"];
        } else {
            $module = Yii::$app->getModule($moduleId);
            $menus = $module->params["menus"];
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
    public function renderView()
    {
        $request = $this->request;
        $query = $request->queryParams;
        $route = $query["page"];
        unset($query['page']);
        if ($this->checkAdminPageRoute($route, $moduleId)) {
            try {
                if (empty($moduleId)) {
                    $data = $this->runAction($route, $query);
                } else {
                    $data = $this->getModule($moduleId)->runAction($route, $query);
                }
            } catch (Exception $exception) {
               $data =  Yii::$app->errorHandler->wpAdminRenderException($exception);
            }
        } else {
            $data = $this->runAction("index/error", new  Exception('找不到路由' . $route));
        }
        if (!empty($data)) {
            Yii::$app->response->data = $data;
            Yii::$app->response->send();
        }
    }

    // +----------------------------------------------------------------------
    // ｜Ajax、RestfulApi、路由配置、解析规则，注册、配置和回调
    // +----------------------------------------------------------------------
    /**
     * 注册控制器ajax操作
     */
    public function registerAjax()
    {
        $menus = $this->params["menus"];
        foreach ($menus as $menu) {
            $menuModel = new AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
        }
    }

    /**
     * ajax和回调
     */
    public function renderAjax()
    {
        try {
            $request = Yii::$app->request;
            $route = $moduleId = '';
            $query = [];
            if ($request->isGet) {
                $query = $request->queryParams;
                if (isset($query['action'])) {
                    $route = $query['action'];
                    unset($query['action']);
                }
            }
            if ($request->isPost) {
                $query = $request->post();
                if (isset($query['action'])) {
                    $route = $query['action'];
                    unset($query['action']);
                }
            }

            if ($this->checkAdminPageRoute($route, $moduleId)) {
                if (empty($moduleId)) {
                    $data = $this->runAction($route, $query);
                } else {
                    $data = $this->getModule($moduleId)->runAction($route, $query);
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

    /**
     * 注册api
     */
    public function registerApi()
    {
        // +----------------------------------------------------------------------
        // ｜注册api路由
        // +----------------------------------------------------------------------
        // ｜支持两种api风格,当主应用和子模块采用不同的风格是，存在解析错误
        // +----------------------------------------------------------------------
        //self::addApi("");
        //self::addRestfulApi("");
    }

    /**
     * 获取RestfulApi路由并执行控制器
     * @param $request
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function renderRestfulApi($request)
    {
        $module = $controller = $route = '';
        $action = self::getActionByHttpMethod();
        $params = $request->get_params();
        // +----------------------------------------------------------------------
        // ｜获取路由$route,$params
        // +----------------------------------------------------------------------
        if (isset($params['module'])) {
            $module = $params['module'];
            unset($params['module']);
        }
        if (isset($params['controller'])) {
            $controller = $params["controller"];
            unset($params['controller']);
        }

        $this->runApi($module, $controller, $action, $route, $params);
    }

    /**
     * 获取Api路由并执行控制器
     *
     * @param $request
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function renderApi($request)
    {

        $module = $controller = $action = $route = $id = '';
        $params = $request->get_params();

        // +----------------------------------------------------------------------
        // ｜获取路由$route,$params
        // +----------------------------------------------------------------------
        if (isset($params['module'])) {
            $module = $params['module'];
            unset($params['module']);
        }
        if (isset($params['controller'])) {
            $controller = $params["controller"];
            unset($params['controller']);
        }
        if (isset($params['action'])) {
            $action = $params["action"];
            unset($params['action']);
        }
        $this->runApi($module, $controller, $action, $route, $params);
    }

    /**
     * 检查路由并执行控制器
     *
     * @param $moduleId
     * @param $controller
     * @param $action
     * @param $route
     * @param $params
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function runApi($moduleId, $controller, $action, $route, $params)
    {
        if ($start = $this->checkApiRoute($moduleId, $controller, $action, $route)) {
            if ($moduleId) {
                $data = Yii::$app->getModule($moduleId)->runAction($route, $params);
            } else {
                $data = Yii::$app->runAction($route, $params);
            }
        }
        if (!empty($data)) {
            Yii::$app->response->data = $data;
            Yii::$app->response->send();
        }
    }

    /**
     * 配置发送邮箱
     *
     * @param SMTP $mail
     */
    public function smtp($mail)
    {
        // 发件人呢称
        $mail->FromName = get_option('crud_group_mail_blogname', 'admin');
        // smtp 服务器地址
        $mail->Host = get_option('crud_group_mail_host', "smtp.qq.com");
        // 端口号
        $mail->Port = get_option('crud_group_mail_port', 465);
        // 账户
        $mail->Username = get_option('crud_group_mail_username', '');
        // 密码
        $mail->Password = get_option('crud_group_mail_password', '');
        // 收件人
        $mail->From = get_option('crud_group_mail_username', 'Crud插件');
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = get_option('crud_group_mail_encryption', "ssl");
        $mail->isSMTP();
    }

    /**
     * 过滤评论
     */
    public function preprocessComment()
    {

    }

    /**
     * 显示设置按钮
     * @param $links
     * @param $file
     * @return mixed
     */
    public function addSettingsButton($links, $file)
    {
        if ($file == 'crud/crud.php') {
            $links[] = '<a href="admin.php?page=base/index">设置</a>';
            $links[] = '<a href="https://www.shiguangxiaotou.com/crud" target="_blank">文档</a>';
        }
        return $links;
    }

    /**
     * 根据http请求方式，返回RestfulApi风格操作id
     * @return string
     */
    public static function getActionByHttpMethod()
    {
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
                break;
            default:
                $action = "index";
        }

        return $action;
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
        $modules = array_keys(Yii::$app->modules);
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
            $controllerNamespace = $defaultControllerNamespace . "\\" . $str[0] . '\\' . ucfirst($str[1]) . "Controller";
            $actionName = 'action' . toScoreUnder(ucfirst($str[2]), "-");
        } else {
            $controllerNamespace = "crud\modules\\" . $str[0] . "\controllers\api\\" . ucfirst($str[2]) . "Controller";
            $actionName = 'action' . toScoreUnder(ucfirst($str[3]), "-");
        }
        return $this->checkRoute($controllerNamespace, $actionName);

    }

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
        $arr = explode('/', $route);
        $count = count($arr);
        $modules = array_keys(Yii::$app->modules);
        $is_module = in_array($arr[0], $modules);
        if ($is_module) {
            $moduleId = $arr[0];
            $route = trim(str_replace($moduleId, "", $route), "/");
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

        return $this->checkRoute($controllerNamespace, $actionName);
    }

    /**
     * 注册Restful 风格api
     * @param string $moduleId
     */
    public static function addRestfulApi($moduleId = '')
    {
        $app = Yii::$app;
        /**
         *  * - `'PUT,PATCH users/<id>' => 'user/update'`: update a user
         * - `'DELETE users/<id>' => 'user/delete'`: delete a user
         * - `'GET,HEAD users/<id>' => 'user/view'`: return the details/overview/options of a user
         * - `'POST users' => 'user/create'`: create a new user
         * - `'GET,HEAD users' => 'user/index'`: return a list/overview/options of users
         * - `'users/<id>' => 'user/options'`: process all unhandled verbs of a user
         * - `'users' => 'user/options'`: process all unhandled verbs of user collection
         */
        if (empty($moduleId)) {
            // indexController注册
            register_rest_route("crud", "api/(?P<id>[\d]+)", [
                'methods' => "PUT,PATCH",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<id>[\d]+)", [
                'methods' => "DELETE",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<id>[\d]+)", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<id>[\d]+)", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api", [
                'methods' => "POST",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            // 模块默认控制器
            register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
                'methods' => "PUT,PATCH",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
                'methods' => "DELETE",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)/(?P<id>[\d]+)", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)", [
                'methods' => "POST",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>[\w]+)", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);

        } else {
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "PUT,PATCH",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "DELETE",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "POST",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);

            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<id>[\d]+)", [
                'methods' => "PUT,PATCH",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<id>[\d]+)", [
                'methods' => "DELETE",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<id>[\d]+)", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<id>[\d]+)", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")", [
                'methods' => "POST",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")", [
                'methods' => "GET,HEAD",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")", [
                'methods' => "OPTIONS",
                'callback' => [$app, "renderRestfulApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
        }
    }

    /**
     * 注册普通api
     * @param string $moduleId
     */
    public static function addApi($moduleId = '')
    {
        $app = Yii::$app;
        if (empty($moduleId)) {
            register_rest_route("crud", "api/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<action>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<action>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
        } else {
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<action>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<id>[\d]+)", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))/(?P<action>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")/(?P<controller>(([a-z]+)-([a-z]+)|([a-z]+)))", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
            register_rest_route("crud", "api/(?P<module>" . $moduleId . ")", [
                'methods' => "GET,POST,HEAD,PUT,PATCH,OPTIONS,DELETE,OPTIONS",
                'callback' => [$app, "renderApi"],
                'permission_callback' => function () {
                    return '';
                },
            ]);
        }
    }
    /**
     * 打印yii2容器中注册的css
     */
    public function printScripts()
    {
        /** @var crud\components\View  $view */
        $view = Yii::$app->getView();
        $view->adminPrintFooterScripts(View::POS_HEAD);
    }

    /**
     * 打印yii2容器中注册的Javascript
     */
    public function printFooterScripts()
    {
        /** @var crud\components\View  $view */
        $view = Yii::$app->getView();
        $view->adminPrintFooterScripts();
    }
}
