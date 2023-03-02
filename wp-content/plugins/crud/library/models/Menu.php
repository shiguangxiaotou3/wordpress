<?php


namespace crud\models;

use Yii;
use yii\base\Model;



/**
 * 注册菜单模型
 *
 * @property string $menu_slug 菜单id
 * @property string|null $page_title 页面titile
 * @property string|null $menu_title 菜单title
 * @property string|null $capability 菜单分类
 * @property string|null $icon_url 图标
 * @property integer|null $position 消息
 * @property integer|null $parent_slug 父级id
 */
class Menu extends Model{

    private $default_title ="Plugins Test";
    private $_plugins;
    public $parent_slug;
    public $page_title;
    public $menu_title;
    public $capability='manage_options';
    public $menu_slug;
    public $icon_url='dashicons-align-full-width';
    public $position=110;

    /**
     * {@inheritdoc}
     */
    public function rules(){
        return [
            ['menu_slug','required',"message" => "菜单id不能为空"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parent_slug' => Yii::t('app', 'Parent Slug'),
            'page_title' => Yii::t('app', 'Page Title'),
            'menu_title' => Yii::t('app', 'Menu Title'),
            'capability' => Yii::t('app', 'Capability'),
            'menu_slug' => Yii::t('app', 'Menu Slug'),
            'icon_url' => Yii::t('app', 'Icon Url'),
            'position' => Yii::t('app', 'Position'),
        ];
    }

    /**
     * @param  $app
     * @param array $menuConfig 菜单配置信息
     */
    public function registerMenu( &$app){
        if($this->validate()) {
            if(isset( $this->parent_slug) and !empty($this->parent_slug)){
                $this->addSubMenu($app);
            }else{
                $this->addMenu($app);
            }
        }
    }

    /**
     * @param  $app
     * 注册一级菜单
     */
    public function addMenu( &$app){
        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$app,"renderView"],
            $this->icon_url,
            $this->position
        );
    }

    /**
     * @param  $app
     * 注册子级菜单
     */
    public function addSubMenu( &$app){
        add_submenu_page(
            $this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            [$app,"renderView"],
            $this->position
        );
    }

    public  function autoTitle(){
        if(empty($this->page_title) and empty($this->menu_title)){
            $router = explode("/",$this->menu_slug);
            foreach ($router as $value){
                $this->default_title =  ucwords($value);
            }
            $this->page_title =$this->menu_title = $this->default_title;
        }
    }
}