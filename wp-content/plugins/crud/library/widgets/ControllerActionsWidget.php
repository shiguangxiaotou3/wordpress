<?php


namespace crud\widgets;


use Yii;
use yii\base\Widget;
use yii\web\Controller;
use crud\model\SettingsSwitch;
/**
 * 生产控制器菜单
 * @package crud\common\widgets
 */
class ControllerActionsWidget extends Widget
{

    /**
     * @var Controller $controller
     */
    public $controller;
    public $actions=[];
    public $defaultUrl="admin.php?page=";
    public $filter;
    private $controllerId;
    private $actionId;


    public function init(){
        parent::init();
        if(empty($this->controller)){
            $this->controller = \Yii::$app->controller;
        }
        $this->controllerId = $this->controller->id;
        $this->actionId = $this->controller->action->id;
        if (empty($this->actions)){
            $this->actions = $this->controller->actions();
        }

    }

    /**
     * @return string|void
     * @throws \Throwable
     */
    public function run(){
        if(!empty($this->actions)){
            $active_menu_slug = ($this->actionId =="index")
                ? $this->controllerId
                :$this->controllerId."/".$this->actionId;
            $activeUrl = $this->defaultUrl.$active_menu_slug;
            $links =[];
            foreach ($this->actions as $action){
                if(($action =="index") ){
                    $menu_slug =  $this->controllerId;
                    $label = self::get_page_title( $menu_slug );
                    $label = empty($label) ? ucwords($action)  :$label ;
                    $links[] =[
                        "label"=> $label ,
                        'url'=>$this->defaultUrl.$menu_slug,
                        "options"=>[],
                    ];
                }elseif (!empty($this->filter) ){
                    $function = $this->filter;
                    if($function($action)){
                        $menu_slug = $this->controllerId."/".$action;
                        $label = self::get_page_title( $menu_slug );
                        $label = empty($label) ? ucwords($action)  :$label ;
                        $links[] =[
                            "label"=> $label ,
                            'url'=>$this->defaultUrl.$menu_slug,
                            "options"=>[],
                        ];
                    }
                }else{
                    $menu_slug = $this->controllerId."/".$action;
                    $label = self::get_page_title( $menu_slug );
                    $label = empty($label) ? ucwords($action)  :$label ;
                    $links[] =[
                        "label"=> $label ,
                        'url'=>$this->defaultUrl.$menu_slug,
                        "options"=>[],
                    ];
                }
            }
            return LinksWidget::widget([
                "activeUrl" => $activeUrl,
                "links" =>  $links,
            ]);
        }
    }


    /**
     * @param $menu_slug
     * @return mixed|string
     */
    public static function get_page_title($menu_slug){
        global $crud;

        $data =$crud->backend->params['menus'];
        $title ="";
        foreach ($data as $datum){
            if($datum["menu_slug"] == $menu_slug){
                return $datum['page_title'];
            }
        }
        return  '';
    }
}