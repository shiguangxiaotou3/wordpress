<?php


namespace crud\widgets;


use crud\assets\HighlightAsset;

use yii\web\View;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class PreCodeWidget
 * @package crud\common\widgets
 */
class PreCodeWidget extends Widget
{

    public $code;
    public $language='php';
    public $theme="monokai_sublime.css";
    public $options =[];
    /**
     *
     * @var HighlightAsset $_assets
     */
    private $_assets;

    public function init(){
        parent::init();
        $css = get_option("crud_group_highlight_theme");
        $this->theme = empty($css)? $this->theme:$css;

    }

    public function run(){
        HighlightAsset::register($this->view)->registerAssetFiles($this->view);
        $assetsPath = $this->view->assetManager->getPublishedUrl("@bower/highlight");
        $this->view->registerCssFile($assetsPath."/styles/".$this->theme);
        $this->view->registerJs('hljs.initHighlightingOnLoad();',View::POS_HEAD);
        return Html::beginTag('pre',$this->options).
            "<code class='language-".$this->language."'>".$this->code."</code>".
            Html::endTag("pre");

    }

}