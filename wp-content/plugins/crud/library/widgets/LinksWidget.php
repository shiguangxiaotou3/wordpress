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
    public $activeClass='current';
    public $links=[];
    public $options =["class"=>"subsubsub"];
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
                if(isset($link['options']["class"])){
                    $link['options']["class"] .="".$this->activeClass;
                }else{
                    $link['options']["class"] =$this->activeClass;
                }
            }
            $a_text = isset($link['label']) ? $link['label']:"全部" ;
            $count = isset($link['count'])? Html::beginTag('span')." (".$link['count'].") "
                .Html::endTag("span"):"";
            $li[] = Html::beginTag("li").
                Html::a($a_text.$count
                    ,$link['url'],$link['options']).
                Html::endTag("li");
        }

        return Html::beginTag("ul",$this->options).join(" | ",$li).Html::endTag("ul");
    }

}