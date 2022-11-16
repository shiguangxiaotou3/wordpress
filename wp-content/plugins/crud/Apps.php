<?php


namespace crud;

use yii\base\BaseObject;



class Apps extends yii\base\BaseObject
{

    public $_backend;
    public $_api;
    public  $_api_namespace = 'crud/api';

    /**
     * @var yii\web\Controller $_controller
     */
    public $_controller;

    /**
     * @return mixed
     */
    public function getBackend()
    {
        return isset($this->_backend) ? $this->_backend : require __DIR__ . "/backend/web/index.php";
    }

    /**
     * @param $app
     */
    public function setBackend($app)
    {
        $this->_backend = $app;
    }

    /**
     * @return mixed
     */
    public function getApi()
    {
        return isset($this->_api) ? $this->_api : require __DIR__ . "/api/web/index.php";
    }

    /**
     * @param $app
     */
    public function setApi($app)
    {
        $this->_api = $app;
    }

    /**
     * 运行
     */
    public function run(){
        // 将设置注册到特定的页面
        add_action("admin_init", [$this, "registerSettings"]);
        add_action("admin_init", [$this, "registerAjaxAction"]);

        // 注册菜单 = 也就是注册yii Controller
        add_action("admin_menu", [$this, "registerPage"]);

        // 为资源包文件创建缓存快，
        add_action("admin_init", [$this, "beginPage"]);
//        add_action("admin_head",[$this,"registerCsrfMetaTags"]);
        add_action("admin_head",[$this,"head"]);
        add_action("wp_body_open",[$this,"beginBody"]);
        add_action("admin_footer",[$this,"endBody"]);
        add_action("admin_print_footer_scripts",[$this,"endPage"]);
        //admin_print_footer_scripts
        // 注册邮件配置
        add_action('phpmailer_init', [$this, 'settingsSmtp']);
        // 注册头像无法访问
        add_filter('get_avatar', [$this, "avatar"]);

        // 创建api
        add_action("rest_api_init", [$this,"registerRestRoute"]);
    }


    public function registerAjaxAction(){
        $menus= $this->backend->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new \crud\common\model\AjaxAction($menu);
            $menuModel->registerAjaxAction($this);
        }
    }


    /**
     * 注册设置
     */
    public function registerSettings()
    {
        $settings = $this->backend->params["settings"];
        foreach ($settings as $setting) {
            $option = new \crud\common\model\Settings($setting);
            $option->registerSettings();
        }
    }

    /**
     * 注册页面,并为页面注册load钩子的 beginPage事件
     */
    public function registerPage(){
        $menus= $this->backend->params["menus"] ;
        foreach ($menus as $menu) {
            $menuModel = new \crud\common\model\Menu($menu);
            $menuModel->registerMenu($this);
        }
    }

    /**
     * 调用控制器显示视图
     */
    public function renderView(){
        $request = $this->backend->request;
        $query =$request->queryParams;
        $action= $query["page"];
        $config = ['index.php'];
        try {
            if (!in_array($action, $config)) {
                /** 注意: 此时返回的子视图文件html,前端资源包为写入
                 * 需要使用Yii::$app->view->endPage()方法写入前端资源包,
                 * wordpress的admin_print_footer_scripts钩子
                 * 自动回调$plugins->endPage()完成资源写入页面
                 */
                echo $this->backend->runAction($action);
                $this->_controller = Yii::$app->controller;
            }
        } catch (Exception $exception) {
            self::exception($exception,debug_backtrace());
        }

    }

    public function renderAjax(){
        $request = $this->backend->request;
        try{

            $request = $this->backend->request;
            $response = $this->backend->response;
            if($request->isAjax){
                if($request->isGet){
                    $action =$request->get("action","");
                }else{
                    $action = $request->post("action","");
                }
                $data = $this->backend->runAction($action);
                echo json_encode($data,true);
//                die();
//                $data = $this->backend->runAction($action);
//                $response->format = \yii\web\Response::FORMAT_JSON;
//                $response->data = [
//                    'success' => $response->isSuccessful,
//                    'code' => $response->getStatusCode(),
//                    'message' => $response->statusText,
//                    'data' =>  $data,
//                ];
//                $response->statusCode = 200;
//                $response->send();
            }
        } catch (Exception $exception) {
            self::exception($exception,debug_backtrace(),'');
        }
        wp_die();

    }

    /**------------------------------
     * 为视图定义资源包缓存快
     *------------------------------*/
    public function registerCsrfMetaTags(){
//        WP_Widget_Meta::widget
//        logObject("执行了");
        $this->backend->view->registerCsrfMetaTags();
//        echo $this->backend->view->registerCsrfMetaTags();
    }
    public function beginPage(){
        $this->backend->view->beginPage();
    }
    public function head(){
        $this->backend->view->head();
    }
    public function beginBody(){
        $this->backend->view->beginBody();
    }
    public function endBody(){
        $this->backend->view->endBody();
    }
    public function endPage(){
        if(isset( $this->_controller)){
            $this->_controller->view->endPage();
        }else{
            $this->backend->view->endPage();
        }
    }
    /*------------------------------*/

    /**
     * @param WP_REST_Request $request
     * @throws yii\base\InvalidRouteException
     */
    public function renderApi(WP_REST_Request $request){
        $params = $request->get_params();
        $version =( isset($params['version']) and !empty($params['version'])) ? $params['version'] : "";
        unset($params['version']);
        $controller = (isset($params['controller']) and !empty($params['controller']) )? $params['controller'] : "index";
        unset($params['controller']);
        $action = (isset($params['action']) and !empty($params['action'])) ? $params['action'] : "index";
        unset($params["action"]);
        echo $this->api->runAction($controller."/".$action,$params);
//        echo $results;
        //自动上传
    }

    /**
     * 删除设置
     */
    public function delSettings()
    {
        $settings = $this->backend->params["settings"];
        \crud\common\model\Settings::delSettings($settings);
    }

    /**
     * 设置smtp服务
     * @param $phpMailer
     */
    public function settingsSmtp($phpMailer)
    {
        if (!empty(get_option('crud_group_mail_host',""))) {
            // 发件人
            $phpMailer->From = get_option('crud_group_mail_username');
            $phpMailer->FromName = get_option("admin_email");
            $phpMailer->Host = get_option('crud_group_mail_host');
            $phpMailer->Port = get_option('crud_group_mail_port', "465");
            $phpMailer->SMTPSecure = get_option('crud_group_mail_encryption');
            $phpMailer->Username = get_option('crud_group_mail_username');
            $phpMailer->Password = get_option('crud_group_mail_password');
            $phpMailer->IsSMTP(); //使用SMTP发送
            $phpMailer->SMTPAuth = true; //启用SMTPAuth服务
        }
    }

    /**
     * 替换作者头像
     * @param $avatar
     * @return string|string[]
     */
    public function avatar($avatar)
    {
        return str_replace([
            'www.gravatar.com/avatar/',
            '0.gravatar.com/avatar/',
            '1.gravatar.com/avatar/',
            '2.gravatar.com/avatar/',
            'secure.gravatar.com/avatar/',
            'cn.gravatar.com/avatar/'
        ], 'sdn.geekzu.org/avatar/', $avatar);
    }


    /**
     * 注册api
     */
    public function registerRestRoute(){
        $rules=[
            // 控制器
            "(?P<controller>[\w]+)",
            // 控制器/方法
            "(?P<controller>[\w]+)/(?P<action>[\w]+)",
            // 控制器/方法/id
            "(?P<controller>[\w]+)/(?P<action>[\w]+)/(?P<id>[\d]+)",
            // 版本/控制器
            "(?P<version>v1|v2)/(?P<controller>[\w]+)",
            // 版本/控制器/方法
            "(?P<version>v1|v2)/(?P<controller>[\w]+)/(?P<action>[\w]+)",
            // 版本/控制器/方法/id
            "(?P<version>v1|v2)/(?P<controller>[\w]+)/(?P<action>[\w]+)/(?P<id>[\d]+)"

        ];
        foreach ($rules as $rule){
            register_rest_route($this->_api_namespace,$rule,[
                'methods' => "GET, POST, PUT, PATCH, DELETE",
                'callback' => [$this,"renderApi"]
            ]);
        }
    }

    /**
     * @param Exception $exception
     * @param $backtrace
     * @param $type
     */
    public static function exception($exception,$backtrace,$type ="html"){
        $msg = $exception->getMessage();
        $code = $exception->getCode();
        if ($type == "html") {
            $str = "<h1> Error: $code </h1>";
            $str .= "<p>$msg</p>";
            $str .= WpTbaleWidget::widget([
                "columns" => [
                    ["field" => "file", "title" => "文件"],
                    ["field" => "line", "title" => "行号"],
                    ["field" => "function", "title" => "函数名"],
                    ["field" => "class", "title" => "类名"],
                    ["field" => "object", "title" => "对象"],
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
}
