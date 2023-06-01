<?php

namespace backend\web;

use Yii;
use Exception;
use crud\modules\wp\Wp;
use yii\web\Application;
use crud\components\View;
use crud\modules\sms\Sms;
use crud\modules\pay\Pay;
use yii\helpers\ArrayHelper;
use crud\modules\movie\Movie;
use crud\modules\market\Market;
use crud\modules\wechat\Wechat;
use crud\components\ErrorHandler;
use crud\components\ApiComponent;
use crud\components\AjaxComponent;
use crud\components\RouteComponents;
use yii\base\InvalidConfigException;
use crud\components\SettingsComponent;
use crud\modules\pay\components\Alipay;
use crud\components\AdminPageComponent;
use crud\modules\base\Base as BaseModule;
use PHPMailer\PHPMailer\PHPMailer as SMTP;
use crud\modules\pay\components\WechatPay;
use crud\components\FrontendPageComponent;
use crud\modules\market\components\Tencent;
use crud\modules\market\components\WechatApplet;
use crud\modules\market\components\BaseComponent;
use crud\modules\wechat\components\SubscriptionService;


/**
 * App对象基类
 *
 *
 * @property-read Alipay $alipay
 * @property-read WechatPay $wechatPay 微信支付
 * @property-read SubscriptionService $subscription 微信公众号
 * @property-read WechatApplet $wechatApplet 微信小程序
 * @property-read Tencent $tencent
 * @property-read BaseComponent $marketApi
 *
 * @property ErrorHandler $errorHandler
 * @property AdminPageComponent $_adminPage 注册和处理后台页面控制器
 * @property SettingsComponent $_settings 注册设置控制器
 * @property AjaxComponent $_ajax 注册和处理ajax控制器
 * @property ApiComponent $_api 注册和处理api控制器
 * @property FrontendPageComponent $_frontendPage 注册和处理前台控制器
 * @property RouteComponents $_route 路由验证
 * @package crud\backend\web
 *
 *
 *
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
            [
                'components' => [
                    '_adminPage' => ['class' => AdminPageComponent::class],
                    '_settings' => ['class' => SettingsComponent::class],
                    '_ajax' => ['class' => AjaxComponent::class],
                    '_api' => ['class' => ApiComponent::class],
                    '_frontendPage' => ['class' => FrontendPageComponent::class],
                    '_route'=>['class'=>RouteComponents::class],

                ]
            ],
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
                "bootstrap" => ['movie',"base",'pay', 'sms', "wechat", 'wp', 'market'],
                'modules' => [
                    'debug' => [
                        'class' => 'yii\debug\Module',
                        'allowedIPs' => ['119.98.223.254','119.98.223.165']
                    ]
                ]
            ],
            BaseModule::config(),
            Pay::config(),
            Market::config(),
            Sms::config(),
            Wechat::config(),
            Wp::config(),
            Movie::config()
        );
    }

    /**
     * 核心:将Yii2操作、事件等挂载到wordpress钩子上
     */
    public function run()
    {

        //plugins_loaded: 在加载所有插件之后，但在任何插件初始化之前。
        //muplugins_loaded: 在加载 Must Use 插件之后，但在其他插件初始化之前。
        //registered_taxonomy: 在注册自定义分类法（Taxonomy）之后执行。
        //registered_post_type: 在注册自定义文章类型（Post Type）之后执行。
        //plugins_loaded: 在加载插件之后执行，但在任何插件初始化之前。
        //sanitize_comment_cookies: 在处理评论 Cookie 之前执行。
        //setup_theme: 在主题设置之前执行。
        //load_textdomain: 在加载翻译文本域之前执行。
        //after_setup_theme: 在主题设置之后执行。
        //auth_cookie_valid: 在验证身份验证 Cookie 之前执行。
        //set_current_user: 在设置当前用户之后执行。
        //init: 在 WordPress 初始化过程中执行，包括加载主题和插件等操作。
        //widgets_init: 在小工具（Widget）初始化之后执行。
        //register_sidebar: 在注册侧边栏之后执行。
        //wp_loaded: 在 WordPress 加载完毕后执行。包括加载主题、插件和处理请求等操作。
        //send_headers: 在发送 HTTP 标头之前执行。
        //parse_request: 在解析请求之前执行。
        //send_headers: 在发送 HTTP 标头之前执行。
        //parse_request: 在解析请求之前执行。
        //pre_get_posts: 在获取文章之前执行。
        //wp: 在生成 WordPress 查询之前执行。
        //template_redirect: 在加载模板文件之前执行。
        //wp_head: 在网页头部输出内容时执行。用于添加自定义 CSS、JavaScript 或其他标签到网页头部。
        //wp_enqueue_scripts: 在前台加载脚本和样式表之前执行。
        //wp_print_styles: 在前台打印样式表之前执行。
        //wp_print_scripts: 在前台打印脚本之前执行。
        //wp_footer: 在网页底部输出内容时执行。用于添加自定义 JavaScript 代码或其他标签到网页底部。
        //admin_bar_init: 在后台管理工具栏初始化之后执行。
        //wp_before_admin_bar_render: 在渲染后台管理工具栏之前执行。
        //wp_after_admin_bar_render: 在渲染后台管理工具栏之后执行。
        //admin_init: 在后台管理界面初始化时执行。适用于在后台加载的插件中添加自定义设置或功能。
        //admin_menu: 在后台管理界面加载菜单时执行。用于添加自定义菜单或修改现有菜单。
        //admin_enqueue_scripts: 在后台加载脚本和样式表之前执行。
        //admin_print_styles: 在后台打印样式表之前执行。
        //admin_print_scripts: 在后台打印脚本之前执行。
        //admin_footer: 在后台管理界面输出底部内容之前执行。
        //wp_dashboard_setup: 在后台仪表盘设置之后执行。
        //in_admin_header: 在后台管理界面头部输出内容之前执行。
        //admin_notices: 在后台管理界面显示通知之前执行。
        //wp_mail: 在发送邮件之前执行。
        //wp_logout: 在注销之后执行。
        //wp_login: 在登录之后执行。
        //shutdown: 在 PHP 进程结束之前执行。

        //wp_login_failed: 在用户登录失败时触发。
        //wp_authenticate: 在用户身份验证过程中执行。
        //wp_logout: 在用户注销登录时触发。
        //wp_ajax_{action}: 处理 AJAX 请求时触发的动作钩子。
        //wp_ajax_nopriv_{action}: 处理非登录用户的 AJAX 请求时触发的动作钩子。
        //wp_print_styles: 在前台打印样式表时触发。
        //wp_print_scripts: 在前台打印脚本时触发。
        //wp_enqueue_scripts: 在前台加载脚本和样式表时触发。
        //wp_footer: 在网页底部输出内容时触发。
        //wp_head: 在网页头部输出内容时触发。
        //admin_init: 在后台管理界面初始化时触发。
        //admin_menu: 在后台管理界面加载菜单时触发。
        //admin_enqueue_scripts: 在后台加载脚本和样式表时触发。
        //admin_print_styles: 在后台打印样式表时触发。
        //admin_print_scripts: 在后台打印脚本时触发。
        //admin_notices: 在后台管理界面显示通知时触发。
        //admin_footer: 在后台管理界面输出底部内容时触发。
        //pre_get_posts: 在获取文章之前触发。
        //template_redirect: 在加载模板文件之前触发。
        //wp_customize_register: 在自定义主题定制器注册之后触发。
        //wp_mail: 在发送邮件之前触发。
        ini_set('magic_quotes_gpc', 'Off');

        date_default_timezone_set('Asia/Shanghai');
        //这是插件加载的第一个钩子，用于在所有插件加载完毕后执行自定义代码
//        add_action('plugins_loaded');
        //该钩子在WordPress初始化过程中执行，包括加载插件和主题等操作
        add_action("init", [$this->_ajax, "registerAjax"]);
        //当后台管理界面初始化时，执行该钩子。适合用于在后台加载的插件中添加自定义设置或功能
        add_action("admin_init", [$this->_settings, "registerSettings"]);
        add_action("admin_menu", [$this->_adminPage, "registerPage"]);

        add_action("rest_api_init", [$this->_api, "registerApi"]);
        //WordPress加载完毕后执行的钩子，包括加载主题、插件和处理请求等操作
//        add_action('wp_loaded');

        add_action('phpmailer_init', [$this, "smtp"]);

        // +----------------------------------------------------------------------
        // ｜JS和css注册和排队钩子
        // +----------------------------------------------------------------------
        add_filter('plugin_action_links', [$this, 'addSettingsButton'], 10, 2);
        add_action('admin_print_scripts', [$this, 'printScripts']);
        add_action("admin_print_footer_scripts", [$this, "printFooterScripts"]);

        add_action('wp_head', [$this, 'printScripts']);
        add_action("wp_footer", [$this, "printFooterScripts"]);
        // +----------------------------------------------------------------------
        // ｜静止自动更新
        // +----------------------------------------------------------------------
        add_filter('pre_site_transient_update_core', function () {
            return null;
        }); // 关闭核心提示
        add_filter('pre_site_transient_update_plugins', function () {
            return null;
        }); // 关闭插件提示
        add_filter('pre_site_transient_update_themes', function () {
            return null;
        }); // 关闭主题提示
        remove_action('admin_init', '_maybe_update_core');    // 禁止 WordPress 检查更新
        remove_action('admin_init', '_maybe_update_plugins'); // 禁止 WordPress 更新插件
        remove_action('admin_init', '_maybe_update_themes');

        // +----------------------------------------------------------------------
        // ｜中国地区头像代理
        // +----------------------------------------------------------------------
//        add_filter('get_avatar', function ($avatar) {
//            return str_replace([
//                'https://www.gravatar.com',
//                'https://0.gravatar.com',
//                'https://1.gravatar.com',
//                'https://2.gravatar.com',
//                'https://secure.gravatar.com',
//                'https://cn.gravatar.com',
//            ], 'https://cn.gravatar.com', $avatar);
//        });
        add_filter('avatar_defaults',  [$this,'avatarUrlDefaults']);
        $this->mapping();
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
     * 打印yii2容器中注册的css
     */
    public function printScripts()
    {
        /** @var View  $view */
        $view = Yii::$app->getView();
        $view->adminPrintFooterScripts(View::POS_HEAD);
    }

    /**
     * 打印yii2容器中注册的Javascript
     */
    public function printFooterScripts()
    {
        /** @var View  $view */
        $view = Yii::$app->getView();
        $view->adminPrintFooterScripts();
    }
    // +----------------------------------------------------------------------
    // ｜下面是将插件的中的某个页面映射到前台的有个路由
    // ｜实现在前台访问插件的页面
    // +----------------------------------------------------------------------
    // ｜只需要子模块的 `bootstrap()`方法中调用 `backend\web\App::route($this->id)`
    // ｜例如`crud\modules\wechat\Wechat`
    // ｜```
    // ｜## Yii::$app 是backend\web\App的实例
    // ｜public function bootstrap($app){
    // |    if ($app instanceof Application) {
    // |        Yii::$app->route($this->id)
    // |    }
    // |}
    // |public function templateRedirect(){
    // |    Yii::$app->templateRedirect($this->id);
    // |}
    // ｜```
    // ｜接下来在前台访问
    // |http://you_domain.com/wechat
    // ｜  就会执行
    // ｜ crud\modules\wechat\controllers\IndexController::actionIndex
    // ｜
    // +----------------------------------------------------------------------

    /**
     * 文件映射
     *
     * 经常需要将一些第三方验证文件放置到根根目录.开起来很乱
     * 通过此方法可以将文件集中管理起来
     * @return void
     */
    public function mapping($files=[]){
        $files =get_option('base_validate_file');
        if(is_array($files) and !empty($files)){
            foreach ($files as $file){
                if(
                    isset($file['filename']) and isset($file['url'])
                    and !empty($file['filename']) and !empty($file['url'])
                ){
                    add_action('init', function ()use($file) {
                        add_rewrite_rule('^'.$file['filename'],
                            'index.php?validateFile='.$file['url'], "top");
                    });
                }
            }
            add_filter('query_vars', function ($public_query_vars){
                if(!in_array('validateFile',$public_query_vars)){
                    $public_query_vars[] = 'validateFile';
                }
                return $public_query_vars;
            });
            add_action("template_redirect", [$this, 'validateFile']);
        }
    }

    /**
     * 获取请求的文件,响应文件流
     *
     * @return void
     */
    public function validateFile(){
        global $wp_query;
        $query_vars = $wp_query->query_vars;
        if (isset($query_vars['validateFile']) and !empty($query_vars['validateFile'])) {
            $path = $query_vars['validateFile'];
            $this->sendFile($path);
        }
    }

    /**
     * 响应文件流
     *
     * @param $path
     * @param $fileSaveName
     * @return void
     */
    public function sendFile($path,$fileSaveName=''){
        if(empty( $fileSaveName)){
            $tmp =explode('/',$path);
            $fileName = end( $tmp );
        }
        if(substr($path, 0, 1) === '/'){
            $path = substr(ABSPATH, 0, -1).$path;
        }
        if(!empty( $fileName) and file_exists($path)){
            header("Content-type:application/octet-stream");
            // 设置下载的文件名称
            header("Content-Disposition:attachment;filename={$fileName}");
            header("Accept-ranges:bytes");
            header("Accept-length:" . filesize($path));
            exit( file_get_contents($path));
        }
    }

    public function avatarUrlDefaults($avatarUrlDefaults){
        $src = 'https://www.shiguangxiaotou.com/wp-content/uploads/2023/05/WechatIMG88.jpeg';//图文url路径
        $avatarUrlDefaults[$src] = "默认头像";//图片的描述名称
        return$avatarUrlDefaults;
    }

}
