<?php


namespace crud\components;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\web\View as YiiView;

class View extends YiiView
{

    /**
     * @param string $css
     * @param array $options
     * @param null $key
     */
    public function registerCss($css, $options = [], $key = null)
    {
        global $wp_styles;
        $handles =$wp_styles->queue;
        if(is_array($handles) and !empty($handles)){
            $handle  =$handles[count($handles)-1];
            wp_add_inline_style($handle, $css);
        }
        $key = $key ?: md5($css);
        $this->css[$key] = Html::style($css, $options);

    }

    /**
     * @param string $js
     * @param int $position
     * @param null $key
     */
    public function registerJs($js, $position = self::POS_READY, $key = null){
        global $wp_scripts;
        if($position == self::POS_READY){
            $js = "jQuery(function ($) {\n" . $js. "\n});";
        }
        if($position ==self::POS_LOAD){
            $js = "jQuery(window).on('load', function () {\n" . $js . "\n});";
        }
        $handles =$wp_scripts->queue;
        if(is_array($handles) and !empty($handles)){
            $handle  =$handles[count($handles)-1];
            wp_add_inline_script(  $handle , $js );
        }

        $key = $key ?: md5($js);
        $this->js[$position][$key] = $js;
        if ($position === self::POS_READY || $position === self::POS_LOAD) {
            JqueryAsset::register($this);
        }
    }
}
