<?php
/** @var $this yii\web\View */
/** @var $this yii\web\View */

use crud\assets\AceAsset;

use crud\widgets\PageHeaderWidget;
use crud\assets\VueAsset;
wp_enqueue_media();
VueAsset::register($this);
AceAsset::register($this);
?>

<div class="wrap" style="" >
    <?= PageHeaderWidget::widget([]) ?>
    <div  style="margin-top: 20px;">
        <div style="height: auto; overflow:hidden;margin: ">
            <ul class="subsubsub" style="margin: 0 0;width: 100%">
                <li><button class="button"  id="save" title="保存" @click="saveFile">保存</button></li>
                <li><button class="button" id="delete" title="删除" @click="deleteFile">删除</button></li>
                <li><button class="button" id="create" title="创建" @click="addFile">创建</button></li>
                <li><button class="button" id="enlarge" title="最大化">最大化</button></li>
                <li>

                        <template v-for="(route,index) in routes" >
                            <div  v-if="index ==0"
                                  @click="routeClick(index)"
                                  class="button last-child"
                                  style="border-top-right-radius: 0;border-bottom-right-radius: 0">
                                    {{route}}
                            </div>

                            <div  v-else-if="index ==(routes.length-1)"
                                  @click="routeClick(index)"
                                  class="button  first-child"
                                  style="margin-left: -1px;border-top-left-radius: 0;border-bottom-left-radius: 0">
                                {{route}}
                            </div>

                            <div  v-else
                                  @click="routeClick(index)"
                                  class="button" style="margin-left: -1px;border-radius: 0">
                                {{route}}
                            </div>
                        </template>
                </li>
                <li><button class="button button-primary-disabled" id="group" title="分组">分组:{{group}}</button></li>
                <li><button class="button button-primary-disabled" id="ownerName" title="所有者">{{ownerName}}</button></li>
                <li><button class="button button-primary-disabled" id="permissions" title="权限">{{permissions}}</button></li>
                <li><button :class="(readable ==true)?'button':'button button-primary-disabled'"  title="读">读</button> </li>
                <li><button :class="(writable ==true)?'button ':'button button-primary-disabled'"  title="写">写</button> </li>
                <li><button :class="(executable ==true)?'button':'button button-primary-disabled'"  title="执行">执行</button></li>
                <li><button class="button"  title="执行" @click="is_show=true">搜索</button> </li>
                <li style="float: right;margin-right: 20px; ">
                    <button class="button" id="setting" title="设置" @click="settingClick">
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
        <pre ref="editor"  id="editor" style="margin-top: 5px;width: 100%;min-height: 500px; "></pre>
    </div>
    <div v-if="is_show" @click="breakClick" :style="breakStyle">
        <div id="ace_settingsmenu" @click.stop="">
            <table role="presentation" id="controls">
                <tr class="ace_optionsMenuEntry">
                    <td><button class="button" @click="search">搜索</button></td>
                    <td><input type="text" v-model="path" class="regular-text code"  placeholder="@backend" /></td>
                </tr>
                <tr>
                    <td colspan="2">当前路由</td>
                </tr>
                <tr v-for="(subItem,index) in subList">
                    <td>
                        <span v-if="subItem.type =='dir'"
                              class="dashicons dashicons-portfolio"
                              style="color: #BDB76B;float: right"></span>
                        <span v-if="subItem.type =='file'"
                              class="dashicons dashicons-format-aside"
                              style="color: #778899;float: right"></span>
                    </td>
                    <td @click="path=subItem.name"  style="color: #2271b1;">{{subItem.name}}</td>
                </tr>
                <tr>
                    <td colspan="2">常用文件</td>
                </tr>
                <tr v-for="(item,index) in list" class="ace_optionsMenuEntry" >
                    <td ><span class="dashicons dashicons-portfolio" style="color: #BDB76B;float: right"></span></td>
                    <td  @click="path=item.name" style="color: #2271b1;">{{item.name}}</td>
                </tr>
                <tr>
                    <td colspan="2">最近编辑</td>
                </tr>
                <tr v-for="(item,index) in storage">
                    <td><span  class="dashicons dashicons-post-status" style="color:#FF6347;float: right"></span></td>
                    <td @click="path=item" style="color: #2271b1;">{{item}}</td>
                </tr>
            </table>
    </div>
</div>
<?php
$path = dirname(__DIR__,5   );
$js=<<<JS
new Vue({
    el: '.wrap',
    data(){
        return {
            ext:'ace/ext/settings_menu',
            theme:'ace/theme/monokai',
            mode:'ace/mode/php',
            value:'',
            editor:'',
            open :'',
            group:'所属组',
            ownerName:'所属用户',
            writable:'',
            readable:'',
            executable:'',
            permissions:'',
            is_Save:false,
            path:'/',
            subList:[],
            list:[
                {'name':'@docs'},
                {'name':'@crud/modules'},
                {'name':'@backend'},
                {'name':'@common'},
                {'name':'@console'},
                {'name':'@crud'},
                {'name':'@vendor'},
                {'name':'@bower'},
                {'name':'@npm'},
                {'name':'@palKey'},
                {'name':'@wechat'},
                
            ],
            breakStyle:{
                margin: '0px;',
                padding: '0px;', 
                position: 'fixed',
                inset: '0px',
                zIndex: 10000000,
                backgroundColor: 'rgba(0, 0, 0, 0.3)'
            },
            is_show:false
        }
    },
     watch:{
        path(newValue,oldValue){
            let config ={
              'php':'ace/mode/php',
              'html':'ace/mode/html',
              'sh':'ace/mode/sh', 
              'py':'ace/mode/python',
              'sql':'ace/mode/mysql', 
              'svg':'ace/mode/svg',
              'json':'ace/mode/json',
              'txt':'ace/mode/text',
              'md':'ace/mode/markdown',
              'js':'ace/mode/javascript',
              'go':'ace/mode/golang',
              'xml':'ace/mode/xml'
            };
           this.updateStorage(newValue);
            this. pathChange(newValue)
            for (let key in config) {
                let value = config[key]
                  if (newValue.includes('.'+key)){
                     this.editor.session.setMode(value );
                     return 
                  }
            }
        }
     },
    computed: {
        routes(){
            if(this.path.startsWith("@")){
                 let s = this.path.trim('/');
                 return s.split('/')
            }else{
                let s = this.path.trim('/')
                let arr= s.split('/')
                  arr.splice(0,1,'/');
                return arr
            }
        },
        storage(){
            let arr = localStorage.getItem('session');
            if(arr == null){
                return [];
            }else{
                return  JSON.parse(arr);
            }
        }
    },
    methods:{
        addFile(){
            let name = prompt("请速入完整路径", this.path);
            if (name != null && name != "") {
                $.ajax({
                    url: ajaxurl+'?action=base/index/editor',
                    type: 'POST',
                    data: {type:'add',name:name},
                    dataType: 'json',
                    success: (res) => {
                        if(res.code ==1){
                            alert(res.message);
                            this.path =name;
                            this.editor.setValue('');
                        }else{
                           alert(res.message); 
                        }
                    }
                });
            }
        },
        deleteFile(){
            $.ajax({
                url: ajaxurl+'?action=base/index/editor',
                type: 'POST',
                data: {type:'delete',name:this.path},
                dataType: 'json',
                success: (res) => {
                    console.log(res)
                    if(res.code ==1){
                        alert(res.message);
                    }else{
                       alert(res.message); 
                    }
                }
            });
        },
        saveFile(){
            let text = this.editor.getValue();
            $.ajax({
                url: ajaxurl+'?action=base/index/editor',
                type: 'POST',
                data: {type:'save',name:this.path,text:text},
                dataType: 'json',
                success: (res) => {
                   
                    if(res.code ==1){
                        alert(res.message);
                    }else{
                       alert(res.message); 
                    }
                }
            });
            
        },
        defaultChange(index){
          this.tmp =index  
        },
        pathChange(path){
            $.ajax({
                url: ajaxurl+'?action=base/index/editor',
                type: 'GET',
                data: {path:path},
                dataType: 'json',
                success: (res) => {
                    if(res.code ==1){
                        if(res.data.info){
                            this.writable=res.data.info.is_writable|| false;
                            this. readable=res.data.info.is_readable || false;
                            this.executable=res.data.info.is_executable || false;
                            this.permissions =res.data.info.permissions || "";
                            this.ownerName = res.data.info.ownerName || "";
                            this.group = res.data.info.group || "";
                            let tmp = res.data.info.text ||"";
                            if(this.editor.getValue() ==''){
                                 this.value  =tmp ;
                                 this.editor.setValue(tmp);
                            }else{
                                 if(this.is_Save ==false && tmp !='' ){
                                   let yes = confirm("你没有报错确定要覆盖吗");
                                   if(yes ){
                                       this.value  =tmp ;
                                       this.editor.setValue(tmp);
                                   }
                                }
                            }
                           
                            
                        }
                        if(res.data.list.length >0){
                            this.subList =res.data.list;
                        }
                    }
                }
            });
        },
        updateStorage(newValue){
          let arr =this.storage
          if(!arr.includes(newValue)){
              arr.push(newValue)
              localStorage.removeItem('session');
              localStorage.setItem('session', JSON.stringify(arr));
          }
        },
        breakClick(e){
            console.log(e)
            this.is_show = false;
        },
        settingClick(e){
            this.editor.showSettingsMenu();
            var element = $('#ace_settingsmenu');
            var parentElement = element.parent();
            parentElement.css('z-index', '10000000');
        },
        aceInit(){
            this.editor = ace.edit('editor');
            ace.require(this.ext).init(this.editor);
            this.editor.getSession().on("change",this.change);
            this.editor.on('changeOptions',this.changeOptions)
            this.editor.setTheme(this.theme);
            this.editor.setValue(this.value);
            this.editor.session.setMode(this.mode);
	        this.editor.commands.addCommands([{
		        name: "showSettingsMenu",
		        bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
		        exec: (editor) =>{
			     this.open =  editor.showSettingsMenu();
		        },
		        readOnly: true
	        }]);
	        window.onload = ()=> {  
                this.editor.resize();
            }  
        },
        search(e){
            console.log(this.path)
        },
        routeClick(index){
            let arr =this.routes;
            let resutl ="/";
            if(index ==0){
               resutl= arr[0]
            }else {
                if(arr[0] =='/'){
                    resutl = "/"+  arr.slice(1, index+1).join('/')
                }else{
                    resutl =   arr.slice(0, index+1).join('/')
                }
            }
            console.log(resutl)
            this.path = resutl;
        },
        change(e){
            console.log(e)    
        },
        changeOptions(e){
            console.log(e) 
        },
        changeHeight(){
            $('#wpbody-content').css('padding-bottom', '0px')
            let wrap = $('#wpwrap').height();
            let bar = $('#wpadminbar').height();
            let body = $("#wpbody").height();
            let editor =$('#editor').height();
            $('#editor').height( wrap-bar-body +editor); 
        }
     },
    mounted() {
        this. changeHeight()
        this.aceInit();
    }
});
JS;
$this->registerJs($js);
?>









<!--<h1>编辑器</h1>-->
<!--<hr class='wp-header-end' />-->
<!--<ul class="subsubsub" id="basePath">-->
<!--    <li><span class="dashicons dashicons-admin-home"></span></li>-->
<!--</ul>-->
<!--<form class="search-form search-plugins" method="get">-->
<!--    <p class="search-box" style="">-->
<!--        <label class="screen-reader-text" for="plugin-search-input">文件:</label>-->
<!--        <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value=""-->
<!--               placeholder="搜索文件" aria-describedby="live-search-desc">-->
<!--        <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">-->
<!--    </p>-->
<!--</form>-->
<!--<hr style='width: 100%;' />-->
<?php //= CodeEditorWidget::widget(["options" => ["id" => "editor", "style" => "margin: 6.5px 0;width: 100%;min-height: 500px"]]); ?>
<!--<div class="menu" id="editorMenu" style="display: none">-->
<!--    <ul>-->
<!--        <li>-->
<!--            <label  class="menuitem" data-action="upload" title="" tabindex="0">-->
<!--                <span class="dashicons dashicons-admin-page"></span>-->
<!--                <span class="displayname" >新建文件</span>-->
<!--            </label>-->
<!--        </li>-->
<!--        <li>-->
<!--            <label  class="menuitem" data-action="upload" title="" tabindex="0">-->
<!--                <span  class="dashicons dashicons-admin-page"></span>-->
<!--                <span class="displayname">新建目录</span>-->
<!--            </label>-->
<!--        </li>-->
<!--    </ul>-->
<!--</div>-->
