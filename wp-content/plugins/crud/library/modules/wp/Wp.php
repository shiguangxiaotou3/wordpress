<?php


namespace crud\modules\wp;




use Yii;
use crud\Base;
use yii\base\Module;
use backend\web\App;
use yii\helpers\ArrayHelper;
use crud\modules\ModuleImplements;

class Wp extends Module implements ModuleImplements
{
    /**
     * @var App
     */
    public $crud;
    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'index';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crud\modules\wp\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(){
        Yii::$app->urlManager->routeParam ='crud';
        global $crud;
        $this->crud = &$crud;
        parent::init();
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
     * 前台注册初始化方法
     */
    public function run(){
        // 向前台注册路由
        add_action('init', function (){
            add_rewrite_rule('^crud','index.php?crud=','top');
        });
        add_action('query_vars',function ($public_query_vars){
            $public_query_vars[] = 'crud';
            return $public_query_vars;
        });
        add_action("template_redirect", [$this,"templateRedirect"]);
//
//        //微信登录
        add_action('login_form', [$this,'login']);
//
//        // 微信分享
//        add_action('the_content',[$this,'WechatShare']);
        // 向前台注册事件
        // 需要去主题<html>和</html>埋点两个点beginPage和endPage
        //add_action("get_template_part",[$this,"beginPage"]);
        add_action("wp_head",[$this->crud,"registerCsrfMetaTags"]);
        add_action("wp_head",[$this->crud,"head"]);
        add_action("wp_head",[$this,"statistics"]);
        add_action("get_template_part_loop",[$this,"wp"]);
        add_action("wp_body_open",[$this->crud,"beginBody"]);
        add_action("wp_footer",[$this->crud,"endBody"]);
    }

    /**
     * 向前台注册全局aeesets
     */
    public function wp(){
        $this->runAction('index/index');
    }

    /**
     * 访问量统计
     */
    public function statistics(){
        $this->crud->app->crawlers->auto();
    }

    /**
     * 显示前台页面
     * @throws \yii\base\InvalidRouteException
     */
    public function templateRedirect(){
        global $wp;
        global $wp_query;
        if(isset($wp_query->query_vars['crud']) ){
            $request = Yii::$app->request;
            $query =$request->queryParams;
            $data =  $this->runAction('index/test',$query);
            Base::sendHtml($data);
            die();
        }
    }

    /**
     * 显示微信登录按钮
     */
    public function login(){
        echo '<button class="button button-primary button-large" style="color:#fff;background: #2a0; float: right; margin: 18px 0 5px 10px; min-height: 32px;" href="" type="button" onClick="openLogin()">微信登陆</button><br />';
    }

    public function WechatShare(){
        $wechat = Yii::$app->wechat;
        $wechat->share();
    }
}