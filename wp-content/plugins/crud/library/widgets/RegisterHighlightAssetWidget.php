<?php
namespace crud\widgets;

use Yii;
use yii\web\View;
use yii\base\Widget;
use crud\assets\HighlightAsset;
class RegisterHighlightAssetWidget extends Widget
{

    public function run(){
        $view =Yii::$app->view;
        $css = get_option("crud_group_highlight_theme","monokai_sublime.css");
        HighlightAsset::register($view);
        HighlightAsset::addCssFile($view,"/styles/".$css);
        $view->registerJs('hljs.initHighlightingOnLoad();');
    }
}