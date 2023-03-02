<?php


namespace crud\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LinksWidget
 * @package crud\common\widgets
 */
class LinksWidget extends  Widget
{
    public $activeUrl;
    public $linkDefaultClass="nav-tab";
    public $linkActiveClass='nav-tab-active';
    public $links=[];
    //<nav class="nav-tab-wrapper wp-clearfix" aria-label="次要菜单">
    public $options =["class"=>"nav-tab-wrapper wp-clearfix"];
    public function init(){
        parent::init();
        if (empty($this->links)){
            return ;
        }
    }
    public function run(){
        $li=[];
        foreach ($this->links as $link){
            if(!isset($link['options'])){
                $link["options"]=["aria-current"=>"page"];
            }
            if($link['url'] == $this->activeUrl){
                $link['options']["class"] =  $this->linkDefaultClass ." ".$this->linkActiveClass;
            }else{
                $link['options']["class"] =  $this->linkDefaultClass ;
            }
            $a_text = isset($link['label']) ? $link['label']:"全部" ;
            $count = isset($link['count']) ? Html::beginTag('span')." (".$link['count'].") "
                .Html::endTag("span"):"";
            $li[] = Html::a($a_text.$count,$link['url'],$link['options']);

        }

        return Html::beginTag("ul",$this->options).join($li).Html::endTag("ul");
    }

}