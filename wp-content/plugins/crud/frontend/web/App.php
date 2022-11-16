<?php


namespace frontend\web;


use Yii;
use Exception;
use yii\web\Controller;
use yii\base\BaseObject;
use yii\web\Application;
use yii\helpers\ArrayHelper;
use crud\widgets\WpTbaleWidget;


/**
 * C
 * @property-read Application $app
 * @package crud\frontend\web
 */
class App extends BaseObject {
    public $_frontend;
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
            require __DIR__ . '/../../common/config/main.php',
            require __DIR__ . '/../../common/config/main-local.php',
            require __DIR__ . '/../config/main.php',
            require __DIR__ . '/../config/main-local.php'
        );
        try {
            $this->_frontend = new Application($config);
        }catch (Exception $exception){
            self::exception($exception,debug_backtrace());
        }

    }

    /**
     * 挂载控制器
     */
    public function run(){
        add_action("get_template_part",[$this,"init"]);
        add_action("wp_head",[$this,"registerCsrfMetaTags"]);
        add_action("wp_head",[$this,"head"]);
        add_action("wp_head",[$this,"visits"]);
        add_action("wp_body_open",[$this,"beginBody"]);
        add_action("wp_footer",[$this,"endBody"]);
    }

    public function visits(){
        $this->app->crawlers->auto();
    }


    /**
     * 前台全局生效事件
     */
    public function init(){
        try {
            $this->renderView("init/index");
        } catch (Exception $exception) {
            self::exception($exception, debug_backtrace());
        }
    }


    /**
     * 获取app容器
     */
    public function getApp(){
        if(isset($this->_frontend)){
            return ($this->_frontend->id !== 'frontend') ? self::__construct() :$this->_frontend;
        }else{
            return self::__construct();
        }
    }

    /**
     * 调用控制器显示视图
     */
    public function renderView($action){
        $config = ['index.php'];
        try {
            if (!in_array($action, $config)) {
                /** 注意: 此时返回的子视图文件html,前端资源包为写入
                 * 需要使用Yii::$app->view->endPage()方法写入前端资源包,
                 * wordpress的admin_print_footer_scripts钩子
                 * 自动回调$plugins->endPage()完成资源写入页面
                 */
                echo  $this->app->runAction($action);
                $this->_controller = $this->app->controller;
            }
        } catch (Exception $exception) {
            self::exception($exception,debug_backtrace());
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
//    public function endPage(){$this->_controller->view->endPage();}
    /**
     * @param Exception $exception
     * @param $backtrace
     * @param string $type
     */
    public static function exception(Exception $exception, $backtrace, $type ="html"){
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