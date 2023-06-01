<?php
/** @var $this yii\web\View */
use yii\helpers\Html;
use crud\assets\AceAsset;
use crud\assets\VueAsset;

VueAsset::register($this);
AceAsset::register($this);
$this->title =get_option('blogname');
$text =<<<TEXT
+---------------------------------------------+
|ubuntu 18.04 LAMP 环境搭建                    | 
+---------------------------------------------+
| win: "Ctrl+q", mac: "Control+q" style       |  
| win: "Ctrl+w", mac: "Control+w" list        |
| win: "Ctrl+s", mac: "Control+s" search      |
+---------------------------------------------+
TEXT;
?>
<div class="warp" v-cloak>
    <div class="nav">
        <a href="/"><?=get_option('blogname')  ?></a>
        <a href="/" class="button">{{info.name}}</a>
    </div>
    <?= Html::beginTag("pre",['id'=>'editor']).Html::endTag("pre") ?>
    <div v-if="modal" @click.stop="searchClose" :style="pop">
        <div v-if="action!=='search'" id="ace_settingsmenu" :style="content">
            <table  role="presentation" id="controls">
                <tr><td colspan="2">文件</td></tr>
                <tr v-for="(subItem,index) in list">
                    <td>
                        <span v-if="subItem.type =='dir'"
                              class="dashicons dashicons-portfolio"
                              style="color: #BDB76B;float: right"></span>
                        <span v-if="subItem.type =='file'"
                              class="dashicons dashicons-format-aside"
                              style="color: #778899;float: right"></span>
                    </td>
                    <td @click="path='@docs/'+subItem.name"  style="color: #2271b1;">{{subItem.name}}</td>
                </tr>
            </table>
        </div>
        <div v-if="action=='search'" :style="searchStyle" @click.stop="">
            <input v-if="action=='search'" type="text" v-model="searchText" style="width: 80%;height: 80px;border-radius: 10px;line-height: 80px;font-size: 50px">
        </div>
    </div>
</div>
<?php
$css= <<<CSS
    body {
        /*overflow: hidden;*/
        width: 100%;height: 100%;
        margin: 0 0;
        padding: 0 0;
   
    }
    .warp{
        position: absolute;
        width: 100%;height: 100%;
        margin: 0 0;
        padding: 0 0;
    }
    .nav{
        height: 50px;
        padding: 0 30px;line-height: 50px;
        font-size: 18px;
        color: #d3d9df;
        background-color: #0082c9;
        background-image: linear-gradient(40deg, #0082c9 0%, #30b6ff 100%);
    }
    .nav a{
        padding: 0 5px;
        color: white;
        text-decoration: none; /* 去除默认的下划线 */
       
    }
    #editor { 
        margin: 0;
        position: absolute;
        top: 50px;
        bottom: 0;
        left: 0;
        right: 0;
    }
    .ace_highlight-marker{
        background-color: red;
    }
    .box{
        position: fixed;
        z-index: 999999;
        right: 0;
        bottom: 0;
        box-sizing: border-box;
        width: 492px;
        padding: 24px 21px;
        background-color: #000;
        border: 1px solid hsla(0,0%,100%,.24);
        color: #ccc;
        opacity: 1;
       
        transition: opacity .3s;
    }
CSS;
$this->registerCss($css);
$js=<<<JS
new Vue({
    el: '.warp',
    data(){
        return {
            ext:'ace/ext/settings_menu',
            theme:'ace/theme/github',
            mode:'ace/mode/sh',
            path:'@docs',
            value:'',
            one:true,
            modal:false,
            info:{},
            list:[],
            editor:'',
            pop:{
                display: 'flex',
                justifyContent: 'flex-start',
                margin: 0,
                padding: 0,
                position: 'fixed',
                inset: 0,
                zIndex: 9990,
                backgroundColor: 'rgba(0, 0, 0, 0.3)'
            },
            content:{
              boxShadow: "5px 4px 5px rgba(126, 126, 126, 0.55)",
              margin: 0,
              bottom: 0,left: 0,top: 0,
              width: '300px'  
            },
            breakStyle:{
                margin: '0px;',
                padding: '0px;', 
                position: 'fixed',
                inset: '0px',
                zIndex: 10000000,
                backgroundColor: 'rgba(0, 0, 0, 0.3)'
            },
            is_show:false,
            action:'',
            searchText:'',
            markerId:'',
            searchStyle:{
                width: "100%",
                padding: ' 5px',
                display: 'flex',
                justifyContent: 'center',
                alignItems:'center'
            }
        }
    },
    watch:{
        searchText(value){
            console.log(value)
            let highlightClass = "ace_highlight-marker";
            if(value !==null && value !==undefined){
                this.editor.find(value,{
                    backwards: false,
                    wrap: false,
                    range:null,
                    caseSensitive: false,
                    wholeWord: false,
                    regExp: false
                });
                this.editor.findNext();
                this.editor.findPrevious();
            }
        },
        path(newValue){
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
            this.getData(newValue);
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
        winWidth(){
            console.log(document.body.clientWidth)
           return  document.body.clientWidth
        },
        show(){
          if(this.one){
              this.action =true;
              return true;
          }
          return false;
        },
    },
    methods:{
        searchClose(){
            if(this.action =='search'){
                this.pop.justifyContent='flex-start'
                delete this.pop.alignItems
                this.action ='' 
            }
            
            this.modal =false;   
        },
        aceInit(){
            this.editor = ace.edit('editor');
            ace.require(this.ext).init(this.editor);
            this.editor.setTheme(this.theme);
            this.editor.session.setMode(this.mode);
            this.editor.setOptions({
                autoScrollEditorIntoView: true,
                copyWithEmptySelection: true,
                fontSize:"20px"
            });
            this.editor.setValue(this.value);
            this.editor.on('change', this.change);  
	        this.editor.commands.addCommands([
                {
                    name: "showSettingsMenu",
                    bindKey: {win: "Ctrl-q", mac: "Ctrl-q"},
                    exec: (editor) =>{
                        this.open =  editor.showSettingsMenu();
                    },
                    readOnly: true
	            },
	            {
                    name: "openList",
                    bindKey: {win: "Ctrl-w", mac: "Ctrl-w"},
                    exec: () =>{
                        this.modal =!this.modal;
                    },
                    readOnly: true
	            },
	            {
                    name: "search",
                    bindKey: {win: "Ctrl-s", mac: "Ctrl-s"},
                    exec: () =>{
                        this.pop.justifyContent='center'
                        this.pop.alignItems='center'
                        this.action ='search'
                        this.modal =!this.modal;
                    },
                    readOnly: true
	            },
            ]);
	        window.onload = ()=> {  
                this.editor.resize();
            } 
            window.\$ace = this.editor
        },
        change(e){
            console.log(e)
        },
        init(value){
             $.ajax({
                url: '/crud/index/ace',
                type: 'GET',
                data: {path:value||this.path},
                dataType: 'json',
                success: (res) => {
                     console.log(res)
                    if(res.code ==1){
                       
                        this.info =res.data.info
                        if(res.data.list.length >0){
                            this.list =res.data.list;
                            this.getData('@docs/ubuntu 18.04 LAMP 环境搭建.sh');
                        }
                    }
                }
            });
        },
        getData(value){
            $.ajax({
                url: '/crud/index/ace',
                type: 'GET',
                data: {path:value||this.path},
                dataType: 'json',
                success: (res) => {
                    console.log(res)
                    if(res.code ==1){
                        this.info =res.data.info
                       if(res.data.list.length >0){
                            this.list =res.data.list;
                        }
                       if(res.data.info.text !=''){
                           this.editor.setValue(res.data.info.text);
                       }
                    }else{
                       alert(res.message); 
                    }
                }
            });
        }
     },
    mounted() {
        this.aceInit();
        this.init();
    }
});
JS;
$this->registerJs($js);


