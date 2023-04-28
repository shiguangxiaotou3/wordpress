<?php
namespace crud\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use crud\models\Files;
use crud\assets\AceAsset;

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
    public $options=[
        'style'=>'margin: 6.5px 0;width: 100%;min-height: 500px'
    ];
    public $basedir =CRUD_DIR;
    public $file ="/library/debug.php";

    public function run(){
        AceAsset::register($this->view);
        $this->view->registerCss("#ace_settingsmenu{margin-top: 32px;}");
        $this->view->registerJs($this->js);
        $pre =Html::beginTag("pre",$this->options).$this->text.Html::endTag("pre");
        return <<<HTML
    <div style="height: auto; overflow:hidden;margin: ">
        <ul class="subsubsub" style="margin: 0 0;width: 100%">
            <li><button class="button" class="current" id="save" title="保存">保存</button></li>
            <li><button class="button" id="delete" title="删除">删除</button></li>
            <li><button class="button" id="create" title="创建">创建</button></li>
            <li><button class="button" id="enlarge" title="最大化">最大化</button></li>
            <li><button class="button button-primary-disabled" id="file_name" title="名称">名称</button></li>
            <li><button class="button button-primary-disabled" id="group" title="分组">分组</button></li>
            <li><button class="button button-primary-disabled" id="ownerName" title="所有者">所有者</button></li>
            <li><button class="button button-primary-disabled" id="permissions" title="权限">权限</button></li>
            <li><button class="button button-primary-disabled" id="is_writable" title="读">读</button> </li>
            <li><button class="button button-primary-disabled" id="is_readable" title="写">写</button> </li>
            <li><button class="button button-primary-disabled" id="is_executable" title="执行">执行</button> </li>
           
            <li style="float: right;margin-right: 20px">
                <button class="button" id="setting" title="设置">
                设置
                </button>
            </li>
            
             <li style="float: right;margin-right: 5px;">
                <span class="button button-primary-disabled " >
                    <kbd>Ctrl</kbd>+<kbd>q</kbd>
                </span>
            </li>
        </ul>
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
    // 初始对象
    function App(config, jQuery){
        this['$']= jQuery;
        for( var i in config ) {
             console.log(i);
            this[i]= config[i];
        }
        this["AppInit"]=function(){
               // 这里this指向app
                let  properties = this.data;
                for( var i in properties ) {
                    // +----------------------------------------------------------------------
                    // ｜错误的写法,原因匿名函数内部this执行windows
                    // +----------------------------------------------------------------------
                    // ｜(function(){
                    // ｜    this[ "get" + i ] = function() {
                    // ｜        return this.data.i;
                    // ｜    };
                    // ｜    this[ "set" + i ] = function(val) {
                    // ｜        this.change(i,val);
                    // ｜        this.data.i = val;
                    // ｜    };
                    // ｜})();
                    // |console.log(this);
                    // +----------------------------------------------------------------------
                    
                    // +----------------------------------------------------------------------
                    // ｜注册getter()和setter()方法
                    // +----------------------------------------------------------------------
                    this.registerGetter(i);
                    this.registerSetter(i);
                };
                //挂载mounted到this上
                if(this.mounted != undefined){
                    for( var fun in this.mounted ){
                        this[fun]= this.mounted[fun];
                    }
                    
                }
          };
        this["registerGetter"]=function (propertiesName){
           this[ "get" +propertiesName ] = function() {
                return this.data[propertiesName];
            };
        };
        this["registerSetter"]=function (propertiesName){
            this[ "set" + propertiesName ] = function(val) {
                this.change(propertiesName,val);
                this.data[propertiesName] = val;
            };
        };
        this['change']=function(name,newVale){
            // 如果监听这个属性则把两次值传给函数
            if(this.watch[name] != undefined){
                this.runWatch = this.watch[name].handler;
                this.runWatch(newVale,this["get"+name]());
            }
            // 更新计算属性
            // 。。。。
            // 更新页面内容
            // 。。。。
        };
        this['runWatch'] =function (){},
        this.AppInit();
        // 下面可以自定义生命周期函数
        if(this['onLoad'] !=undefined ){
            this['onLoad']();
        }
        if(this['run'] != undefined){
            this['run']();
        }
    };
    
    const app = new App({
        data:{
            "Nav":"basePath",
            "Menu":"editorMenu",
            'Editor':"",
            "BaseDir":"{$this->basedir}",
            "Id":"{$this->options["id"]}",
            "Ext":"{$this->ext}",
            'Theme':"{$this->theme}",
            "Mode":"{$this->mode}",
            "Value":'{$this->text}',
            'ActiveDir':"{$this->basedir}",
            "Action":"/wp-admin/admin-ajax.php?action=base/index/editor",
            "FileList":{},
            "Group":0,
            "OwnerName":"",
            "Permissions":0755,
            'Is_writable':true,
            "Is_readable":true,
            "Is_executable":true  
        },
        watch:{
            FileList:{
                deep:true,
                handler:function(newVale,oldValue){
                   this. RefreshFileList(newVale);
                }
            },
            Group:{
                deep:true,
                handler:function(newVale,oldValue){
                    
                }
            },
            OwnerName:{
                deep:true,
                handler:function(newVale,oldValue){
                    
                }
            },
            Permissions:{
                deep:true,
                handler:function(newVale,oldValue){
                    
                }
            },
            Is_writable:{
                deep:true,
                handler:function(newVale,oldValue){
                    
                }
            },
            Is_readable:{
                deep:true,
                handler:function(newVale,oldValue){
                    
                }
            },
            Is_executable: {
                deep:true,
                handler:function(newVale,oldValue){
                    if(newVale){
                        this.$("#is_executable").removeClass("button-primary-disabled")
                    }else{
                        this.$("#is_executable").addClass("button-primary-disabled");
                        
                    }
                }
            },
            file_name:{
                deep:true,
                handler:function(newVale,oldValue){
                }
            }
        },
        onLoad:function(){
            let editor = window.ace.edit(this.getId());
            ace.require(this.getExt()).init(editor);
            editor.setTheme(this.getTheme());
            editor.setValue(this.getValue());
            editor.session.setMode(this.getMode());
	        editor.commands.addCommands([{
		        name: "showSettingsMenu",
		        bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
		        exec: function(editor) {
			        editor.showSettingsMenu();
		        },
		        readOnly: true
	        }]);
	        this.setEditor(editor);
	        window.onload =function () {
                editor.resize();
            }
            
            let nav = "#"+this.getNav();
            // 打卡设置选择
            this.$("#setting").click(function (){
                editor.showSettingsMenu();
            });
	        // 点击打开文件列表
            this.$(nav +" li").click((e)=>{
                
            });
            // // 鼠标移入
            // this.$("#"+this.getNav()+" li").mouseover((e)=>{
            //      this.$("#"+this.getBox()).show();
            // });
            // // 鼠标移出
            //  this.$("#"+this.getNav()+" li").mouseover((e)=>{
            //      this.$("#"+this.getBox()).hide();
            // });
        },
        mounted:{
            // 重新跟新窗口
            changeCanvasHeight:function(){
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
            },
            // 获取当下目录的文件列表
            ApiGetFileList:function(callBack){
                this.$.ajax({
                    url:this.getAction(),
                    dataType:"json",
                    data:{'baseDir':this.getBaseDir(),'type':"List"},
                    success:(res)=>{
                        callBack(res);
                    },
                    error:function(res){
                        console.log(res);
                    }
                });
            },
            // 显示菜单
            ShowMenu:function(e,offsetX,offsetY){
                let x = e.clientX;
                let y = e.clientY;
                let elMenu = "#"+this.getMenu();
                this.$(elMenu).top =y + offsetX+"px";
                this.$(elMenu).let =x + offsetY +"px";
                this.$( elMenu).css({"left": x+"px","top": y+"px","z-index":"100"}).show();
            },
            // 新增文件
            PushFileList:function(){
                
            },
            // 跟新文件
            UpDateFileList:function(){
                
            },
            DeleteFileList:function(){
                
            },
            RefreshFileList:function (newVale){
                let elDir = this.$("#"+this.getNav());
                let elmenu = this.$("#"+this.getMenu());
                this.$(elmenu  +" ul").remove()
                let activeDir = this.getActiveDir();
                let dirs = newVale.dir;
                let files = newVale.files;
                for(var i =0 ;i<= dirs.length -1;i++){
                    this.$(elmenu +" ul").append(`
                    <li>
                        <label  class="menuitem" data-dir='`+ activeDir +"/" + dirs[i] +`' data-action="upload" title="" tabindex="0">
                            <span  class="dashicons dashicons-portfolio" style='color: #ffdb99'></span>
                            <span class="displayname">`+ dirs[i]+`</span>
                        </label>
                    </li>`);
                }
                for(var x =0 ;x<= files.length-1;x++){
                    this.$(elmenu  +" ul").append(`
                    <li>
                        <label  class="menuitem" data-dir='`+ activeDir +"/" + files[x] +`' data-action="upload" title="" tabindex="0">
                            <span  class="dashicons dashicons-media-code" style='color: #2271b1;'></span>
                            <span class="displayname">`+ files[x]+`</span>
                        </label>
                    </li>`);
                }
            }
        },
        run:function (){
            if(this.getFileList() == ""){
                this.ApiGetFileList( (res)=>{
                    console.log(res.data);
                      // this.setFileList(res.data);
                });
            }
        }
    }, jQuery);
    window.app = app;
    
//    //调整大小
//    function change_canvas_heigth(){
//        var wpwrap_height = document.getElementById("wpwrap").offsetHeight;
//        var wpfooter_height =document.getElementById("wpfooter").offsetHeight;
//        document.getElementById("wpbody-content").style.paddingBottom ='0';
//        var wpcontent_height = document.getElementById("wpcontent").offsetHeight;
//        // 空白区域高度
//        var h = wpwrap_height - wpfooter_height - wpcontent_height;
//        if(h >0){
//            var canvas_heigth = document.getElementById("editor").offsetHeight;
//            document.getElementById("editor").style.height = canvas_heigth + h +"px"
//        }
//    }
//    $("#enlarge").click(change_canvas_heigth);
//    $("#setting").click(function (){
//        editor.showSettingsMenu();
//    });
//    var editor = window.ace.edit("{$this->options["id"]}");
//    var fileInfo = {$file};
//    ace.require('{$this->ext}').init(editor);
//    editor.setTheme("{$this->theme}");
//    editor.setValue('{$this->text}');
//    var fileInfo ={
//        "file_name":"",
//         "group":0,
//         "ownerName":"",
//        "permissions":0755,
//        'is_writable':true,
//        "is_readable":true,
//        "is_executable":true   
//    };
//    if(fileInfo){
//        editor.setValue(fileInfo.text);
//        if(fileInfo.name !== ""){
//            $("#file_name").text(fileInfo.name );
//        }
//        if(fileInfo.group !== ""){
//            $("#group").text(fileInfo.group );
//        }
//        if(fileInfo.ownerName !== ""){
//            $("#ownerName").text(fileInfo.ownerName );
//        }
//        if(fileInfo.permissions !== ""){
//            $("#permissions").text(fileInfo.permissions );
//        }
//       
//        if(fileInfo.is_writable == true){
//            editor.setReadOnly(false);
//            $("#is_writable").removeClass('button-primary-disabled');
//        }else {
//             editor.setReadOnly(true);
//             $("#is_writable").addClass('button-primary-disabled');
//        }
//        if(fileInfo.is_writable == true){
//            $("#is_readable").removeClass('button-primary-disabled');
//        }else {
//             $("#is_readable").addClass('button-primary-disabled');
//        }
//        if(fileInfo.is_executable == true){
//            $("#is_executable").removeClass('button-primary-disabled');
//        }else {
//             $("#is_executable").addClass('button-primary-disabled');
//        }
//    }
//    editor.session.setMode("{$this->mode}");
//	editor.commands.addCommands([{
//		name: "showSettingsMenu",
//		bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
//		exec: function(editor) {
//			editor.showSettingsMenu();
//		},
//		readOnly: true
//	}]);
//	window.onresize=change_canvas_heigth;
//	window.onload =function () { 
//        change_canvas_heigth();
//        editor.resize();
//     }
JS;
    }

    /**
     * 获取文件详细信息
     * @param $path
     * @return array|bool
     */
    public function getFileInfo($path){
        return Files::fileInfo($path);
    }

    public function icons(){
        return [
        ];
    }
}