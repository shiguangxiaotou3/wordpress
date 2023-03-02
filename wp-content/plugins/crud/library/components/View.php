<?php
namespace crud\components;

use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\helpers\ArrayHelper;
use yii\web\View as YiiView;
use yii\base\InvalidConfigException;

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
        $key = $key ?: md5($js);
        $this->js[$position][$key] = $js;
        if ($position === self::POS_READY || $position === self::POS_LOAD) {
            JqueryAsset::register($this);
        }
    }
    public function adminPrintFooterScripts($position=self::POS_READY){
        global $wp_scripts;
        $handles =$wp_scripts->queue;
        if(is_array($handles) and !empty($handles)){
            $handle  =$handles[count($handles)-1];
//            if(isset($this->js[self::POS_HEAD])){
//                $js = ArrayHelper::merge(
//                    $this->js[self::POS_HEAD],
//                    $this->js[self::POS_READY]
//                );
//            }
            if(!empty(($this->js)[$position])){
                $js = "jQuery(function ($) {\n" . implode("\n", $this->js[self::POS_READY]) . "\n});";
                wp_add_inline_script(  $handle , $js  );
            }

        }
    }
}
