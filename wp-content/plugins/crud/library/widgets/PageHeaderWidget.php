<?php
namespace crud\widgets;

use yii\base\Widget;
use crud\widgets\SearchWidget;
use crud\widgets\ControllerActionsWidget;
class PageHeaderWidget extends Widget
{
    public $searchOptions=[];
    public $searchResponse='';
    public $buttons=[];
    public $isVue=false;

    public function run(){
        $title = $error='';
        if(function_exists('get_admin_page_title') and  function_exists('esc_html')){
            $title = esc_html( get_admin_page_title() ) ?: "";
        }

        $ui = ControllerActionsWidget::widget();
        $buttons = join(' ',$this->buttons);
        if(function_exists('settings_errors')){
            $error =settings_errors();
        }

        return "
        <h1 class='wp-heading-inline'>
            ".$title."
        </h1>
         {$buttons}
        <hr class='wp-header-end' />
        ".$ui.$error;
    }
}