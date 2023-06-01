<?php

namespace crud\components;

use Yii;
use backend\web\App;
use yii\base\Component;
use yii\base\InvalidRouteException;
class FrontendPageComponent extends Component
{

    /**
     * @param string $moduleId
     * @param string|null $alias url前缀别名
     * @param string|null $controller_prefix 控制器命名空间前缀
     * @return void
     */
    public function registerFrontendRule($moduleId='',$alias='',$controller_prefix='frontend'){
        /** @var App $app */
        $app = Yii::$app;
        if(empty($moduleId)){
            $moduleId = $app->id;
            $module = $app;
        }else{
            $module = $app->getModule($moduleId);
        }
        if(empty($alias)){
            $alias = $moduleId;
        }
        if(!empty($controller_prefix)){
            $controller_prefix=  trim($controller_prefix,"/").'/';
        }
        if(!empty($moduleId) ){
            add_action('init', function ()use($alias,$controller_prefix) {
                add_rewrite_rule('^'.$alias.'$',
                    'index.php?'.$alias.'='.$controller_prefix.'index/index', "top");

                add_rewrite_rule('^'.$alias.'/([^/]+)$',
                    'index.php?'.$alias.'='.$controller_prefix.'$matches[1]/index', "top");

                add_rewrite_rule('^'.$alias.'/([^/]+)/([^/]+)$',
                    'index.php?'.$alias.'='.$controller_prefix.'$matches[1]/$matches[2]', "top");

                add_rewrite_rule('^'.$alias.'/([^/]+)/([^/]+)/([0-9]+)$',
                    'index.php?'.$alias.'='.$controller_prefix.'$matches[1]/$matches[2]&id=$matches[3]', "top");
            });
            add_filter('query_vars', function ($public_query_vars) use($alias){
                if(!in_array($alias,$public_query_vars)){
                    $public_query_vars[] = $alias;
                }
                if(!in_array('id',$public_query_vars)){
                    $public_query_vars[] = 'id';
                }
                return $public_query_vars;
            });
            add_action("template_redirect", [$module->_frontendPage, "templateRedirect"]);
        }
    }

    /**
     *  根据重写的url规则 显示页面
     * @param $moduleId
     * @param $alias
     * @return void
     * @throws InvalidRouteException
     */
    public function templateRedirect($moduleId='',$alias='')
    {
        if(empty($moduleId)){
            $moduleId = Yii::$app->id;
            $module = Yii::$app;
        }else{
            $module = Yii::$app->getModule($moduleId);
        }
        if(empty($alias)){
            $alias = $moduleId;
        }
        if(empty($alias)){
            $alias = $moduleId;
        }
        if(!empty($moduleId)){
            global $wp_query;
            $query_vars = $wp_query->query_vars;
            if (isset($query_vars[$alias]) and !empty($query_vars[$alias])) {
                $route = $query_vars[$alias];
                $params = $query_vars;
                $response = Yii::$app->response;
                $response->format ='html';
                $response->setStatusCode(200);
                unset($query_vars[$alias]);
                exit($module->runAction($route, $params));
                $response->data = $module->runAction($route, $params) ;
                $response->send();
                exit();
            }
        }
    }

}