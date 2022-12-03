<?php


namespace crud\widgets;


use crud\assets\AceAsset;
use yii\base\Widget;
use yii\helpers\Html;

class CodeEditorWidget extends  Widget
{
    public $ext= AceAsset::EXT_SETTINGS_MENU;
    public $mode = AceAsset::MODE_PHP;
    public $theme= AceAsset::THEME_TWILIGHT;
    public $options=[];

    public function run(){
        AceAsset::register($this->view);
        $id= $this->options["id"];
        $js =<<<JS
    var editor = window.ace.edit("{$id}");
    console.log(editor);
    ace.require('{$this->ext}').init(editor);
    editor.setTheme("{$this->theme}");
    editor.session.setMode("{$this->mode}");
	editor.commands.addCommands([{
		name: "showSettingsMenu",
		bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
		exec: function(editor) {
			editor.showSettingsMenu();
		},
		readOnly: true
	}]);
JS;
        $css =<<<CSS
        #ace_settingsmenu{
            margin-top: 32px;
        }
CSS;
        $this->view->registerCss( $css);
        $this->view->registerJs($js);
        return Html::beginTag("pre",$this->options).Html::endTag("pre");
    }
}