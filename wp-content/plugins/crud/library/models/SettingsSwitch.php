<?php


namespace crud\models;

use yii\base\Model;







/**
 * 小工具开关
 * @package crud\common\model
 */
class SettingsSwitch  extends Model{

    public static function getSwitchSettings(){
        $settings =get_option("crud_group_switch_switch");
        if(empty($settings)){
            return [];
        }else{
            return $settings;
        }

    }

    /**
     * 获取小工具是否开启
     * @param $section_id
     * @return bool
     */
    public static function getSwitch($section_id){
        return in_array($section_id,self::getSwitchSettings());
    }

    /**
     * 设置小工具开关
     * @param $section_id
     * @param $value
     * @return bool
     */
    public static function setSwitch($section_id,$value){
        $switchSettings = self::getSwitchSettings();
        if($value){
            if( !in_array($section_id,$switchSettings)){
                array_push($switchSettings,$section_id);
            }
        }else{
            if( in_array($section_id,$switchSettings)){
                $arr =array_flip($switchSettings);
                unset($arr[$section_id]);
                $switchSettings = array_flip( $switchSettings);
            }
        }
        update_option("crud_group_switch_switch",$switchSettings);
    }
}