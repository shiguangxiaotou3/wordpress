<?php
namespace crud\common\events;
use Yii;
use yii\base\Event;

class AddPage  extends Event
{
    /**
     * @param  yii\base\ActionEvent $event
     */
    public  static function addPage($event){
        logObject($event);
        /** @var yii\base\InlineAction $action */
        $action = $event->action;
        $controller = $action->controller;
        $controllerId = $action->id;
        $actionId=$action->controller->id;

        if($actionId =="index"){
            add_menu_page(
                ucwords($controllerId),
                ucwords($controllerId),
                "manage_options",
                "$actionId",
                [ $controller,"getData"],
                'dashicons-align-full-width',
                110
            );
        }else{
            add_submenu_page(
                "$controllerId",
                ucwords($actionId),
                ucwords($actionId),
                "manage_options",
                "$actionId/$actionId",
                [ $controller,"getData"],
                110
            );
        }
    }

}