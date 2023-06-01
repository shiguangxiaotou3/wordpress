<?php
namespace crud\modules\base;

use Yii;
use yii\base\Module;
use yii\web\Application;
use crud\models\AjaxAction;
use crud\Base as BaseModule;
use yii\helpers\ArrayHelper;
use yii\base\BootstrapInterface;
use crud\modules\ModuleImplements;

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
            // ｜阿里对象存储，更文章中img的url
            // +----------------------------------------------------------------------
//            add_filter( 'the_content', [$this, 'imageDisplayProcessing'] );
            add_action("init", [$this, "registerAjax"]);
        }
    }

    /**
     * 替换文章的媒体文件
     * @param $content
     * @return string|string[]|null
     */
    public function imageDisplayProcessing($content){
        $home = get_option('home')."/wp-content/uploads/";
        $ossUrl ='https://shiguangxiaotou.oss-cn-beijing.aliyuncs.com/';
        // 图片
        $pattern = '#<img[\s\S]*?src\s*=\s*[\"|\'](.*?)[\"|\'][\s\S]*?>#ims';  // img匹配正则
        $content = preg_replace_callback(
            $pattern,
            function($matches) use ($home,$ossUrl) {
                if (strpos($matches[1], $home) === false) {
                    return $matches[0];
                } else {
                    return str_replace($home, $ossUrl, $matches[0]);
                }
            },
            $content);
        // 视频
        $video="#<video[\s\S]*?src=\s*[\"|\'](.*?)[\"|\'][\s\S]*?>#ims";
        $content = preg_replace_callback(
            $video,
            function($matches) use ($home,$ossUrl) {
                if (strpos($matches[1], $home) === false) {
                    return $matches[0];
                } else {
                    return str_replace($home, $ossUrl, $matches[0]);
                }
            },
            $content);
        return $content;
    }

    public function registerAjax(){
//        $menus=[];
        $config =[
            'movie',
        ];
        $actions =['init','index','create','view','update','delete','deletes'];
        foreach ($config as $menu){
            foreach ($actions as $action){
                $menuModel = new AjaxAction(['menu_slug'=>$this->id."/".$menu."/".$action]);
                $menuModel->registerAjaxAction();
            }
        }
    }
}