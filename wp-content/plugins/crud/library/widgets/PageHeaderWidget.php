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

    public function run(){
        $parent_title = get_admin_page_parent();
        $title = esc_html( get_admin_page_title() );
        $ui = ControllerActionsWidget::widget();
        $buttons = join(' ',$this->buttons);
        return "
        <h1 class='wp-heading-inline'>
            ".$title."
        </h1>
         {$buttons}
        <hr class='wp-header-end' />
        ".$ui.settings_errors();
    }
}