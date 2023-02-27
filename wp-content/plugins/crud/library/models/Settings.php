<?php
namespace crud\models;

use yii\base\Model;
use yii\helpers\Html;



/**
 * 设置api
 *
 * ```
 * # 这是字段命名规则：
 * $option_group + "_" + $section_id + "_" + $field_id
 * # 例如 "crud_group_admin_test"
 * ```
 * @property string $option_group 分组名称
 * @property string $page 显示页面
 * @property string $section_title 分组标题
 * @property string $section_id 分组id
 * @property string|null $section_description 分组说明
 * @property array $fields 字段
 * @property array|null $args
 */
class Settings extends Model{

    public $option_group = "crud_group";
    public $page="index/settings";
    public $section_id="settings";
    public $section_title;
    public $section_description;
    public $fields=[];
    /**
     * 可选择值
     *
     * ```
     * [
     *  'type'              => 'string',
     *  'description'       => '',
     *  'sanitize_callback' => null,
     *  'show_in_rest'      => false,
     * ]
     * ```
     * @var array $args
     */
    public $args=[];

    /**
     * {@inheritdoc}
     */
    public function rules(){
       return [

       ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [];
    }

    /**
     * 注册设置
     */
    public function registerSettings(){
        $fields = $this->fields;
        $section_title = empty($this->section_title) ? ucwords($this->section_id) : $this->section_title;
        foreach ($fields as $field) {
            $field_id = $this->option_group . "_" . $this->section_id . "_" . $field["id"];
            register_setting(
                $this->option_group."_" . $this->section_id,
                $field_id,
                $this->args
            );
            add_settings_section($this->section_id, $section_title, [$this, "sectionCallback"], $this->page);

            $field_title = empty($field["title"]) ? ucwords($field["id"]) : $field["title"];
            $field_args = isset($field['args']) ? $field['args'] : [];
            $field_args["name"] = isset($field['args']['name']) ? $field['args']['name'] : $field_id;
            $field_args["options"]['id'] = isset($field_args["options"]['id']) ? $field_args["options"]['id'] : $field_id;
            add_settings_field(
                $field_id,
                $field_title,
                [$this,"fieldCallback"],
                $this->page,
                $this->section_id,
                $field_args
            );
        }

    }

    /**
     *  section回调
     */
    public function sectionCallback(){
        echo "<p>".$this->section_description."</p>";
    }

    /**
     * 表单原生回调
     * @param $args
     */
    public function fieldCallback($args){
        $tag = (isset($args['tag']) and !empty($args['tag'])) ? $args['tag'] : "text";
        $options = isset($args["options"]) ? $args["options"] : [];
        $name = $args["name"];
        $defaultValue = isset($args['defaultValue']) ? $args['defaultValue'] : "";
        $description = (isset($args["description"]) and !empty($args["description"])) ? $args["description"] :"";
        if ($tag == "text") {
            $value = get_option($name, $defaultValue);
            echo Html::textInput($name, $value, $options);
        } elseif ($tag == "password") {
            $value = get_option($name, $defaultValue);
            echo Html::passwordInput($name, $value, $options);
        }elseif ($tag == "checkbox"){
            $value = get_option($name, $defaultValue);
            echo Html::checkbox($name, $value, $options);
        }elseif ($tag == "dropDownList"){
            $value = get_option($name, $defaultValue);
            echo Html::dropDownList($name, $value,$args['items'],$args['options']);
        } elseif ($tag == "switch"){
            $value = get_option($name);
            $value =(isset($value) and !empty($value) and is_array($value)) ? $value : [];
            $switch = $args['switch'];
            $item_html =[];
            foreach ($switch as $item) {
                $key =$item["options"]['value'];
                $item_description =( isset($item["description"]) and !empty($item["description"]))
                    ? $item["description"]
                    : ucwords($key );
                $checked = in_array($key, $value);
                $input= Html::checkbox($name . "[]",  $checked, $item['options']);
                $item_html[] ="<lable style='margin: 0.35em 0 0.5em!important;display: inline-block;'> " .$input.$item_description ."</lable>";
            }
            echo "<fieldset>".join("<br />",$item_html)."</fieldset>";
        }elseif ($tag == "textarea"){
            $value = get_option($name, $defaultValue);
            echo Html::textarea( $name,$value, $options);
        }

        echo (!empty($description)) ? "<p>$description</p>" :"";
    }

    /**
     * 删除Setting
     * @param $option_group
     * @param $option_name
     */
    public static function delSetting($option_group,$option_name){
        return unregister_setting($option_group,$option_name);
    }

    /**
     * 批量删除设置
     * @param $sections
     */
    public static function delSettings($sections){
        foreach ($sections as $section){
            $option_group=$section["option_group"];
            $section_id = $section["section_id"];
            foreach ($section['fields'] as $file){
                $option_name = $option_group."_".$section_id."_".$file['id'];
                self::delSetting($option_group,$option_name);
            }

        }
    }
}