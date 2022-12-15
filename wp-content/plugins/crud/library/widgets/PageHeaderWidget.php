<?php


namespace crud\widgets;


use yii\base\Widget;
use crud\widgets\SearchWidget;
use crud\widgets\ControllerActionsWidget;
class PageHeaderWidget extends Widget
{
    public $controllerOptions=[];
    public $searchOptions=[];
    public $searchResponse='';

    public function run(){
        $parent_title = get_admin_page_parent();
        $title = esc_html( get_admin_page_title() );
        $ui = ControllerActionsWidget::widget($this->controllerOptions);
        $search = SearchWidget::widget($this->searchOptions);
        $searchResponse ="";
        if(!empty( $this->searchResponse)){
            $searchResponse ="<hr style='width: 100%;' />";
        }
        return "
        <h1 class='wp-heading-inline'>
            ".$parent_title."
            <small>".$title."</small>
        </h1>
        <hr class='wp-header-end' />
        ".$ui.$search.settings_errors()."
        <hr style='width: 100%;' />
        ".$searchResponse;

    }
}