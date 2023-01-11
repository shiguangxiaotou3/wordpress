<?php


namespace crud\modules\editor\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use crud\models\Files;
use crud\modules\editor\assets\AceAsset;






/**
 * Class CodeEditorWidget
 * @property-read $js
 * @package crud\modules\editor\widgets
 */
class CodeEditorWidget extends  Widget
{
    public $ext= AceAsset::EXT_SETTINGS_MENU;
    public $mode = AceAsset::MODE_PHP;
    public $theme= AceAsset::THEME_TOMORROW_NIGHT_BRIGHT;
    public $text ="";
    public $loadFile =false;
    public $options=[];
    public $basedir =CRUD_DIR;
    public $file ="/library/debug.php";

    public function run(){
        AceAsset::register($this->view);
        $this->view->registerCss("#ace_settingsmenu{margin-top: 32px;}");
        $this->view->registerJs($this->js);
        $pre =Html::beginTag("pre",$this->options).$this->text.Html::endTag("pre");
        return <<<HTML
    <div>
        <ul class="subsubsub" style="margin: 0 0">
            <li><button class="button" class="current" id="save">保存</button></li>
            <li><button class="button" id="delete">删除</button></li>
            <li><button class="button" id="create">创建</button></li>
            <li><button class="button" id="enlarge">最大化</button></li>
            <li><button class="button button-primary-disabled" id="file_name">名称</button></li>
            <li><button class="button button-primary-disabled" id="group">分组</button></li>
            <li><button class="button button-primary-disabled" id="ownerName">所有者</button></li>
            <li><button class="button button-primary-disabled" id="permissions">权限</button></li>
            <li><button class="button button-primary-disabled" id="is_writable">读</button> </li>
            <li><button class="button button-primary-disabled" id="is_readable">写</button> </li>
            <li><button class="button button-primary-disabled" id="is_executable">执行</button> </li>
            <li><button class="button button-primary-disabled" id="setting"><code>Ctrl</code>+<code>q</code></button></li>
        </ul>

        <form class="search-form search-plugins" method="get">
            <p class="search-box" style="">
                <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
                <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value=""
                       placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
                <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
            </p>
        </form>
    </div>
    {$pre}
HTML;
    }

    /**
     * @return string
     */
    public function getJs(){
        $file =  $this->getFileInfo($this->basedir.$this->file);
        if(isset($file) and !empty($file)){
            $file = json_encode($file);
        }else{
            $file =false;
        }
return <<<JS
    function change_canvas_heigth(){
        var wpwrap_height = document.getElementById("wpwrap").offsetHeight;
        var wpfooter_height =document.getElementById("wpfooter").offsetHeight;
        document.getElementById("wpbody-content").style.paddingBottom ='0';
        var wpcontent_height = document.getElementById("wpcontent").offsetHeight;
        // 空白区域高度
        var h = wpwrap_height - wpfooter_height - wpcontent_height;
        if(h >0){
            var canvas_heigth = document.getElementById("editor").offsetHeight;
            document.getElementById("editor").style.height = canvas_heigth + h +"px"
        }
    }
    $("#enlarge").click(change_canvas_heigth);
    $("#setting").click(function (event){});
    var editor = window.ace.edit("{$this->options["id"]}");
    var fileInfo = {$file};
    ace.require('{$this->ext}').init(editor);
    editor.setTheme("{$this->theme}");
    editor.setValue('{$this->text}');
    if(fileInfo){
        editor.setValue(fileInfo.text);
        if(fileInfo.name !== ""){
            $("#file_name").text(fileInfo.name );
        }
        if(fileInfo.group !== ""){
            $("#group").text(fileInfo.group );
        }
        if(fileInfo.ownerName !== ""){
            $("#ownerName").text(fileInfo.ownerName );
        }
        if(fileInfo.permissions !== ""){
            $("#permissions").text(fileInfo.permissions );
        }
       
        if(fileInfo.is_writable == true){
            editor.setReadOnly(false);
            $("#is_writable").removeClass('button-primary-disabled');
        }else {
             editor.setReadOnly(true);
             $("#is_writable").addClass('button-primary-disabled');
        }
        if(fileInfo.is_writable == true){
            $("#is_readable").removeClass('button-primary-disabled');
        }else {
             $("#is_readable").addClass('button-primary-disabled');
        }
        if(fileInfo.is_executable == true){
            $("#is_executable").removeClass('button-primary-disabled');
        }else {
             $("#is_executable").addClass('button-primary-disabled');
        }
    }
    editor.session.setMode("{$this->mode}");
	editor.commands.addCommands([{
		name: "showSettingsMenu",
		bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
		exec: function(editor) {
			editor.showSettingsMenu();
		},
		readOnly: true
	}]);
	window.onresize=change_canvas_heigth;
	window.onload =function () { 
        change_canvas_heigth();
        editor.resize();
     }
JS;

    }

    public function getFileInfo($path){
        return Files::fileInfo($path);
    }
}