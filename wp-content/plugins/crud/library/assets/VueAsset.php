<?php
namespace crud\assets;

use Yii;
use yii\web\View;
class VueAsset extends AppAsset {

    public $sourcePath =  "@bower/vue/dist";
    public $css = [
    ];
    public $js = [
        "vue.js"
    ];
    public $jsOptions=[];
    public $depends = ['yii\web\JqueryAsset'];
    public static function loadComponents(){
        $component =[
            'common.js','modal.js','table.js','tablenav-pages.js',
            'notice.js','columns.js','nav-tab-wrapper.js','crud.js','from.js'
        ];
        $path =Yii::getAlias("@crud/assets/js/component");
        $js ='';
        foreach ($component as $item){
            $js .=PHP_EOL.file_get_contents($path."/".$item);
        }
        return $js;
    }
}
/**
 * The location of registered JavaScript code block or files.
 * 注册的JavaScript代码块或文件的位置
 * 这意味着位置在头部.
 */
const POS_HEAD = 1;
/**
 * 注册的JavaScript代码块或文件的位置.
 * 这意味着该位置位于主体部分的开头.
 */
const POS_BEGIN = 2;
/**
 * The location of registered JavaScript code block or files.
 * 注册的JavaScript代码块或文件的位置
 * 这意味着该位置位于body部分的末端
 * This means the location is at the end of the body section.
 */
const POS_END = 3;
/**
 * 注册的JavaScript代码块的位置
 * The location of registered JavaScript code block.
 * 这意味着JavaScript代码块将包含在`jQuery(document).ready()`
 * This means the JavaScript code block will be enclosed within `jQuery(document).ready()`.
 */
const POS_READY = 4;
/**
 * 注册的JavaScript代码块的位置
 * The location of registered JavaScript code block.
 * 这意味着JavaScript代码块将包含在`jQuery(window).load()`
 * This means the JavaScript code block will be enclosed within `jQuery(window).load()`.
 */
const POS_LOAD = 5;
/**
 * 这在内部用作占位符，用于接收为标题部分注册的内容
 * This is internally used as the placeholder for receiving the content registered for the head section.
 */
const PH_HEAD = '<![CDATA[YII-BLOCK-HEAD]]>';
/**
 * 这在内部用作占位符，用于接收为正文部分开头注册的内容
 * This is internally used as the placeholder for receiving the content registered for the beginning of the body section.
 */
const PH_BODY_BEGIN = '<![CDATA[YII-BLOCK-BODY-BEGIN]]>';
/**
 * 这在内部用作占位符，用于接收正文部分末尾注册的内容
 * This is internally used as the placeholder for receiving the content registered for the end of the body section.
 */
const PH_BODY_END = '<![CDATA[YII-BLOCK-BODY-END]]>';