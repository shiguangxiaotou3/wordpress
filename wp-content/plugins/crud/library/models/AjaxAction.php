<?php
namespace crud\models;

use yii\base\Model;
/**
 * 注册ajax
 *
 * @property string $menu_slug 菜单id
 * @property string|null $page_title 页面titile
 * @property string|null $menu_title 菜单title
 * @property string|null $capability 菜单分类
 * @property string|null $icon_url 图标
 * @property integer|null $position 消息
 * @property integer|null $parent_slug 父级id
 */
class AjaxAction extends Model
{
    private $default_title ="Plugins Test";
    private $_plugins;
    public $parent_slug;
    public $page_title;
    public $menu_title;
    public $capability='manage_options';
    public $menu_slug;
    public $icon_url='dashicons-align-full-width';
    public $position=110;

    public function registerAjaxAction(&$app){
        add_action("wp_ajax_".$this->menu_slug,[$app,"renderAjax"]);
        wp_localize_script(
            'ajax-script',
            'crud',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'title_example' ),
            )
        );
        add_action("wp_ajax_nopriv_".$this->menu_slug,[$app,"renderAjax"]);
        add_action("wp_ajax_".$this->menu_slug,[$app,"renderAjax"]);
    }
}