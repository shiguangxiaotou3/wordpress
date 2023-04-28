<?php
namespace crud\assets;

use yii\web\View;

class HighlightAsset  extends AppAsset {

    public $sourcePath =  "@bower/highlight";
    public $css = [
        'mac.css'
    ];
    public $js = [
        'highlight.pack.js',"mac.js"
    ];
    public $jsOptions=[
        "position"=>View::POS_HEAD,
    ];
    public $depends = ['yii\web\JqueryAsset'];
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