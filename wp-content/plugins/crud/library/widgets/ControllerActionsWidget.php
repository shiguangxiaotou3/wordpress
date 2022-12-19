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
    private $moduleId;
    private $controllerId;
    private $actionId;


    public function init(){
        parent::init();
        if(empty($this->controller)){
            $this->controller = Yii::$app->controller;
        }
        $this->moduleId = $this->controller->module->id;
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
            // 判断是否为加载的模块
            if ($this->moduleId == Yii::$app->id) {

                if(($this->actionId == "index")){
                    $active_menu_slug =$this->controllerId;
                }else{
                    $active_menu_slug =$this->controllerId . "/" . $this->actionId;
                }
                $tmlUrl =$this->controllerId;
            } else {
                if($this->actionId == "index"){
                    $active_menu_slug = $this->moduleId . "/" . $this->controllerId;
                }else{
                    $active_menu_slug = $this->moduleId . "/" . $this->controllerId . "/" . $this->actionId;
                }
                $tmlUrl =$this->moduleId . "/" . $this->controllerId;
            }
            $activeUrl = $this->defaultUrl . $active_menu_slug;
            $links = [];
            foreach ($this->actions as $key=> $action) {
                $action = is_array($action) ? $key : $action;

                if (($action == "index")) {
                    $menu_slug = $tmlUrl;
                    $label = self::get_page_title($menu_slug);
                    $label = empty($label) ? ucwords($action) : $label;
                    $links[] = [
                        "label" => $label,
                        'url' => $this->defaultUrl . $menu_slug,
                        "options" => [],
                    ];
                } elseif (!empty($this->filter)) {
                    $function = $this->filter;
                    if ($function($action)) {
                        $menu_slug = $tmlUrl.'/'.$action;
                        $label = self::get_page_title($menu_slug);
                        $label = empty($label) ? ucwords($action) : $label;
                        $links[] = [
                            "label" => $label,
                            'url' => $this->defaultUrl . $menu_slug,
                            "options" => [],
                        ];
                    }
                } else {
                    $menu_slug = $tmlUrl.'/'.$action;
                    $label = self::get_page_title($menu_slug);
                    $label = empty($label) ? ucwords($action) : $label;
                    $links[] = [
                        "label" => $label,
                        'url' => $this->defaultUrl . $menu_slug,
                        "options" => [],
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
        $data =Yii::$app->params['menus'];
        $title ="";
        foreach ($data as $datum){
            if($datum["menu_slug"] == $menu_slug){
                return $datum['page_title'];
            }
        }
        return  '';
    }
}