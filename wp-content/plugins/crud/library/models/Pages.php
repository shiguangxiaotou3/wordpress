<?php


namespace crud\models;


use yii\base\Model;

/**
 * Class Pages
 *

 * @property string|null $page_title 页面titile
 * @property string|null $menu_title 菜单title
 * @property string|null $capability 页面分类
 * @property string $menu_slug 页面id
 * @property string|null $callback 图标
 * @property integer|null $position 消息
 * @package crud\common\model
 */
class Pages extends Model
{
    public $page_title;
    public $menu_title;
    public $capbility='manage_options';
    public $menu_slug;
    public $posiyion="";


    /**
     * @param $plugins
     */
    public function registerPages(&$plugins){
        add_pages_page(
            $this->page_title,
            $this->menu_title,
            $this->capbility  ,
            $this->menu_slug,
            [$plugins,"renderView"],
            $this->posiyion,
        );
    }


}