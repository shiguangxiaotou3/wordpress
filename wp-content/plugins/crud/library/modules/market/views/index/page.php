<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
use crud\assets\JqueryUiAsset;
use crud\modules\market\assets\MarketAsset;


wp_enqueue_media();
wp_enqueue_editor();
MarketAsset::register($this);
JqueryUiAsset::register($this);
?>


    <div class="wrap" id="vue">
        <?= PageHeaderWidget::widget() ?>
        <div id="nav-menus-frame" class="wp-clearfix">
            <div id="menu-settings-column" class="metabox-holder">
                <div class="clear"></div>
                <h2>添加菜单项</h2>
                <div id="side-sortables" class="accordion-container">
                    <ul class="outer-border">
                        <!-- 首页 -->
                        <li class="control-section">
                            <h3 class="accordion-section-title"
                                @click="index=1" tabindex="0">
                                首页<span class="screen-reader-text"></span>
                            </h3>
                            <div class="accordion-section-content"
                                 :style="(index ==1)? 'display: block;':'display: none;'">
                                <div class="inside">
                                    <ul class="order">
                                        <li class="order-li" @click="swiperClick">
                                            <div class="order-title">
                                                <div class="sub-text">轮播图</div>
                                            </div>
                                        </li>
                                        <li class="order-li"  @click="noticeClick">
                                            <div class="order-title">
                                                <div class="sub-text">通知</div>
                                            </div>
                                        </li>
                                        <li class="order-li">
                                            <div class="order-title">
                                                <div class="sub-text">仓库</div>
                                            </div>
                                        </li>
                                        <li class="order-li" @click="courseClick">
                                            <div class="order-title">
                                                <div class="sub-text">教程中心</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- end 首页 -->
                        <li class="control-section">
                            <h3 class="accordion-section-title"
                                @click="index=2" tabindex="1">
                                商品<span class="screen-reader-text"></span>
                            </h3>
                            <div class="accordion-section-content"
                                 :style="(index ==2)? 'display: block;':'display: none;'">
                                <div class="inside">
                                    <ul class="order">
                                        <li class="order-li" @click="commodityClick">
                                            <div class="order-title">
                                                <div class="sub-text">分类</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
                <div style="width: 100%;padding: 10px">
                    <a class="button submitdelete deletion menu-delete"
                       @click="addPage">新增页面
                    </a>
                    <a class="button submitdelete deletion menu-delete"
                       @click="deletePage" style="color: #b32d2e;">删除页面
                    </a>
                    <a class="button submitdelete deletion menu-delete" @click="test"
                       style="color: #b32d2e;">测试
                    </a>
                </div>
            </div>
            <div id="menu-management-liquid">
                <div id="menu-management">

                    <h2>参数设置</h2>
                    <div class="menu-edit">
                        <div id="nav-menu-header">
                            <div class="major-publishing-actions wp-clearfix" style="padding: 10px 0px">
                                <label class="menu-name-label" for="menu-name" v-html="title"></label>
                            </div>
                        </div>

                        <div class="post-body">
                            <div v-show="show" class="major-publishing-actions wp-clearfix">
                                    <!-- swiper -->
                                    <div v-show="clickType =='swiper'">

                                        <div class="drag-instructions post-body-plain">
                                            <p >轮播头图片比例w:h=15:8 <br>其他尺寸或导致变形</p>
                                        </div>
                                        <div class="theme-browser rendered">
                                            <div class="themes wp-clearfix ">
                                                <div  class="theme active"
                                                    v-for="(image,index) in swiper.list">
                                                    <div class="theme-screenshot">
                                                        <img :src="image.url">
                                                    </div>
                                                    <button type="button"  class="more-details" @click="editor(image)">详情</button>
                                                    <div class="theme-id-container">
                                                        <h2 class="theme-name">{{image.title}}</h2>
                                                        <div class="theme-actions">
                                                            <a class="button button-primary customize load-customize hide-if-no-customize"
                                                               @click="swiper.list.splice(index,1)"
                                                            >删除</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="theme add-new-theme">
                                                    <a  @click="upload">
                                                        <div class="theme-screenshot"><span></span></div>
                                                        <h2 class="theme-name">添加图片</h2>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">是否显示面板指示点</span>
                                            <input type="text"
                                                ref="indicatorDots"
                                                v-model="swiper.indicatorDots"
                                                class="regular-text"
                                                placeholder="名称">
                                        </label>


                                        <label  style="display: flex;flex-direction: column;margin-bottom: 13px">
                                            <span class="field-title">自动播放</span>
                                            <input type="text"
                                               ref="autoplay"
                                               v-model="swiper.autoplay"
                                               class="regular-text"
                                               placeholder="true">
                                        </label>


                                        <label  style="display: flex;flex-direction: column;margin-bottom: 13px">
                                            <span class="field-title">播放间隔(毫秒)</span>
                                            <input type="text"
                                                ref="interval"
                                                v-model="swiper.interval"
                                                class="regular-text"
                                                placeholder="true">
                                        </label>

                                        <label  style="display: flex;flex-direction: column;margin-bottom: 13px">
                                            <span class="field-title">动画时长(毫秒)</span>
                                            <input type="text"
                                                ref="auration"
                                                v-model="swiper.auration"
                                                class="regular-text"
                                                placeholder="true">
                                        </label>

                                    </div>
                                    <!-- end swiper -->

                                    <!--notice -->
                                    <div v-show="clickType =='notice'">
                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">开始时间</span>
                                            <input type="text" ref="beginTime"
                                                   v-model="notice.beginTime"
                                                   class="regular-text" placeholder="" />
                                        </label>

                                         <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                             <span class="field-title">结束时间</span>
                                             <input type="text" ref="endTime" v-model="notice.endTime" class="regular-text"  value="" />
                                        </label>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">通知文本</span>
                                            <textarea class="large-text code" v-model="notice.text" rows="5" placeholder="通知文本"></textarea>
                                        </label>
                                    </div>
                                    <!-- end notice -->


                                   <!-- end notice -->
                                    <div  v-show="clickType =='course'">
                                        <textarea  ref="editor" id="editor" v-model="course" class="editor"></textarea>
                                    </div>

                                    <div v-show="clickType =='commodity'">
                                        <label for="custom-menu-item-url" class="howto">分类</label>
                                        <select    v-model="commodity" @change="commodityChange">
                                            <option disabled="disabled" vaule="">请选择分类</option>
                                            <option v-for="(item,index) in commodityList" :value="item.id">{{item.categorize_name}}</option>
                                        </select>
                                        <button type="button" value="新增" class="button" @click="addCategory" >新增</button>

                                        <select    v-model="subCommodity">
                                            <option disabled="disabled" vaule="">请选择子分类</option>
                                            <option v-for="(item,index) in subCommodityList" :value="item.id">{{item.categorize_name}}</option>
                                        </select>
                                        <button type="button" value="新增" class="button" @click="addCategory" >新增</button>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">名称</span>
                                            <input type="text" v-model="commodity_name" class="regular-text" placeholder="" />
                                        </label>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">型号</span>
                                            <input type="text" v-model="commodity_type" class="regular-text" placeholder="" />
                                        </label>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">商品颜色</span>
                                            <input type="text" v-model="commodity_color" class="regular-text" placeholder="" />
                                        </label>
                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">图片</span>
                                            <div class="theme-browser rendered">
                                                <div class="themes wp-clearfix ">
                                                    <div  class="theme active"
                                                          v-for="(image,index) in commodity_image">
                                                        <div class="theme-screenshot">
                                                            <img :src="image.url">
                                                        </div>
                                                        <button type="button"  class="more-details" @click="editor(image)">详情</button>
                                                        <div class="theme-id-container">
                                                            <h2 class="theme-name">{{image.title}}</h2>
                                                            <div class="theme-actions">
                                                                <a class="button button-primary customize load-customize hide-if-no-customize"
                                                                   @click="commodity_image.splice(index,1)"
                                                                >删除</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="theme add-new-theme">
                                                        <a  @click="upload">
                                                            <div class="theme-screenshot"><span></span></div>
                                                            <h2 class="theme-name">添加图片</h2>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>






                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">描述</span>
                                            <textarea v-model="commodity_describe" class="large-text code" style="min-width: 400px;min-height: 200px" placeholder="ip地址查询.多个ip','隔开" ></textarea>
                                        </label>
                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">其他参数</span>
                                            <input type="text" v-model="commodity_storage" class="regular-text" placeholder="" />
                                        </label>
<!--                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">-->
<!--                                            <span class="field-title">图片</span>-->
<!--                                            <input type="text" v-model="commodity_image" class="regular-text" placeholder="" />-->
<!--                                        </label>-->


                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">关键子</span>
                                            <input type="text" v-model="commodity_keyword" class="regular-text" placeholder="" />
                                        </label>

                                        <label  style="display: flex;flex-direction: column;margin: 13px 0px">
                                            <span class="field-title">备注</span>
                                            <input type="text" v-model="remarks" class="regular-text" placeholder="" />
                                        </label>

                                    </div>

                            </div>
                        </div>

                        <div class="nav-menu-footer">
                            <div class="major-publishing-actions wp-clearfix">
                                <span class="delete-action" style="">
                                    <input type="submit" value="关闭"
                                        class="submitdelete deletion menu-delete"
                                        style="color: #b32d2e;"
                                        @click="show=!show"/>
                                </span>
                                <div class="publishing-action" style="">
                                    <input type="submit" @click="submit"
                                        class="button button-primary button-large menu-save"
                                        value="保存菜单"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <crud-modal ref="modal" :title="modalTitle" :active="modalActive">
            <div class="ftp-username">
                <label for="username">
                    <span class="field-title">FTP用户名</span>
                    <input name="username" type="text"  value="">
                </label>
            </div>
            <p class="request-filesystem-credentials-action-buttons">
                <button class="button cancel-button" type="button" @click="modalActive=false">取消</button>
                <input type="submit"  class="button" value="继续" @click="submit">
            </p>
        </crud-modal>
    </div>

<?php
$js =<<<JS
Vue.component('crud-modal', {
    template: `
<div class="notification-dialog-wrap request-filesystem-credentials-dialog" :style="(active)?'display: block;':'display: none;'">
  <div class="notification-dialog-background"></div>
  <div class="notification-dialog" role="dialog">
    <div class="request-filesystem-credentials-dialog-content">
        <div class="request-filesystem-credentials-form">
          <h2>{{title}}</h2>
          <slot></slot>
        </div>
    </div>
  </div>
</div>`,
    data() {
        return {}
    },
    props: {
        title:{
            type: String,
            default: '测试弹窗',
        },
        active:{
            type:Boolean,
            default:false
        }
    },
    computed: {},
    methods: {}
});

Vue.prototype.\$ =\$
Vue.prototype.\$wp =wp
const app2 = new Vue({
    el: '#vue',
    data(){
        return {
            index:0,
            clickType:'',
            swiper:{
                indicatorDots:true ,
                autoplay:true,
                interval:3000,
                auration:1000,
                list:[]  
            },
            swiper_show:false,
            notice_show:false,
            notice:{
                beginTime:'',
                endTime:'',
                text:''
            },
            title:'状态栏',
            show:false,
            commodity:'',
            commodityList:[
                {id:'',name:'',subList:[]}
            ],
            subCommodity:"",
            subCommodityList:[],
            modalActive:false,
            modalTitle:'新增分类',
            course:'<h2>这是一个例子</h2>',
            noticeOne:false,
            courseOne:false,
            
            commodity_name:'',
            commodity_type:'', 
            commodity_color:'',
            commodity_storage:'',
            commodity_describe:'', 
            commodity_image:[], 
            commodity_keyword:'',
            remarks:'',
          
        }
    }, 
    //监听
    watch: {
        clickType(oldValue,newValue){
            console.log(oldValue)
            if(this.show){
                if(oldValue =='notice' && this.noticeOne == false){
                     this.noticeInit();
                     this.noticeOne = true
                }
                if(oldValue =='course' && this.courseOne == false){
                    this.courseInit();
                    this.courseOne = true    
                }
            }
        },
        course(){
            console.log(this.course)
        }
    },
    //计算属性
    computed: {
        imagesStr(){
          return this.swiper.list.join(';')
        },
    },
    methods: {
        debug(){
            console.log('n:'+this.n+' subN:'+this.subN+' type:'+this.type) 
        },
        pageInit(){
            jQuery.ajax({
                url:'/wp-json/crud/api/market/index/swiper',
                type: 'GET',
                dataType:"json",
                 success:(res)=>{
                    if(res.code ==1){
                        this.swiper = res.data;
                    }
                 }
            });
        },
        addPage(){
            
        },
        deletePage(){
            
        },
        deleteItem(){
            
        },
        save(){
            
        },
        
        swiperClick(){
          this.clickType ='swiper';
          this.title ='轮播图';
          this.show =true;
        },
        swiperUpload(e){
            e.preventDefault();
            let image = wp.media({
                title: '请选择媒体',
                library: {type: 'image'},
                button: {text: '选择'},
                multiple: true
            })
            .open()
            .on('select',()=>{
                console.log(this)
                let images = image.state().get('selection').toArray();
                console.log(images)
                for(let i =0;i<=(images.length -1);i++){
                    let img_item =(images[i]).toJSON();
                    this.swiper.list.push(img_item) 
                }
            }).on('close',()=>{
                let images = image.state().get('selection').toArray();
                console.log(images.length)
            });
        },
        swiperSubmit(){
            jQuery.ajax({
                url:ajaxurl+"?action=market/index/page",
                type: 'POST', 
                data:{'swiper':this.swiper},
                dataType:'json',
                 success:(res)=>{
                     console.log(res)
                    if(res.code ==1){
                        alert('提交成功')
                    }else {
                         alert('提交失败')
                    }
                 }
            });
        },
        editor(image){
            let attachment = wp.media.attachment(image.id);
            var frame = wp.media({
                title: '编辑媒体',
                library: {
                    type: 'image'
                },
                button: { text: '选择' }
            });
            frame.on('open', function() {
                var selection = frame.state().get('selection');
                selection.add(attachment);
            });
            frame.open();
        },
        upload(e){
            if(this.clickType =='swiper'){
               this.swiperUpload(e)
            }else if(this.clickType =='commodity'){
                this.commodityUpload(e)
            }
        },
        
        noticeInit(){
            this.$(this.\$refs.beginTime).datepicker({
                onSelect:(dateText, inst)=>{
                    this.notice.beginTime =dateText;
                }
            });
            this.$(this.\$refs.endTime).datepicker({
                onSelect:(dateText, inst)=>{
                    this.notice.endTime =dateText;
                }
            });
        },
        noticeClick(){
            this.clickType ='notice';
            this.title ='通知';
            this.show =true;
        },
        noticeSubmit(){
            console.log(this.notice)
            jQuery.ajax({
                url:ajaxurl+"?action=market/index/page",
                type: 'POST', 
                data:{'notice':this.notice},
                dataType:'json',
                success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        alert('提交成功')
                    }else {
                         alert('提交失败')
                    }
                }
            });
        },
        test(){
            let html = this. \$wp.editor.getContent('my_custom_field');
            console.log(html)
          
           
        },
        
        courseClick(){
            this.clickType ='course';
            this.title ='教程';
            this.show =true;
        },
        courseInit(){
            console.log('执行了')
            const \$editor = $(this.\$refs.editor);
            const editorId = \$editor.prop('id');
            console.log(this.\$wp.editor.getDefaultSettings())
            this.\$wp.editor.initialize( editorId,{
                tinymce: {
                    wpautop: true ,
                    theme: 'modern' ,
                    skin: 'lightgray' ,
                    selector: '#'+editorId,
                    language: 'zh' ,
                    formats: {
                        alignleft: [
                        {selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li' , styles: {textAlign: 'left' }},
                        {selector: 'img, table, dl.wp-caption' , classes: 'alignleft' }
                        ],
                        aligncenter: [
                        {selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li' , styles: {textAlign: 'center' }},
                        {selector: 'img, table, dl.wp-caption' , classes: 'aligncenter' }
                        ],
                        alignright: [
                        {selector: 'p, h1, h2, h3, h4, h5, h6, td, th, div, ul, ol, li' , styles: {textAlign: 'right' }},
                        {selector: 'img, table, dl.wp-caption' , classes: 'alignright' }
                        ],
                        strikethrough: {inline: 'del' }
                    },
                    relative_urls: false ,
                    remove_script_host: false ,
                    convert_urls: false ,
                    browser_spellcheck: true ,
                    fix_list_elements: true ,
                    entities: '38, amp, 60, lt, 62, gt ' ,
                    entity_encoding: 'raw' ,
                    keep_styles: false ,
                    paste_webkit_styles: 'font-weight font-style color' ,
                    preview_styles: 'font-family font-size font-weight font-style text-decoration text-transform' ,
                    tabfocus_elements: ': prev ,: next' ,
                    plugins:  'link, image,charmap, hr, media, paste, tabfocus, textcolor, fullscreen, wordpress, wpeditimage, wpgallery, wplink, wpdialogs, wpview' , 
                    resize: 'vertical' ,
                    menubar: false ,
                    indent: false ,
                    toolbar1: ' bold, italic, strikethrough, bullist, numlist, blockquote, hr, alignleft, aligncenter, alignright, link, unlink, wp_more, spellchecker, fullscreen, wp_adv' ,
                    toolbar2: 'image, formatselect, underline, alignjustify, forecolor, pastetext, removeformat, charmap, outdent, indent, undo, redo, wp_help' ,
                    toolbar3: '' ,
                    toolbar4: '' ,
                    body_class: 'id post-type-post-status-publish post-format-standard' ,
                    wpeditimage_disable_captions: false ,
                    wpeditimage_html5_captions: true,
                    branding: false,
                    statusbar: true,
                    mode: 'exact'
                },
                quicktags: true,
                mediaButtons: true,
                setup: function( editor) {
                    console.log('asd')
                    // this.course = editor.getContent();
                    editor.on('change', function(){
                        console.log(editor.getContent())
                        this.course = editor.getContent();
                    });
                    editor.on('click', () => {
                        console.log('Editor was clicked');
                    });
                },   
            });
        },
        courseSubmit(){
            const \$editor = this.\$(this.\$refs.editor);
            const editorId = \$editor.prop('id');
            let html = this. \$wp.editor.getContent(editorId);
            console.log(this.course);
             console.log(html)
            jQuery.ajax({
                url:ajaxurl+"?action=market/index/page",
                type: 'POST', 
                data:{'course':html},
                dataType:'json',
                success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        alert('提交成功')
                    }else {
                         alert('提交失败')
                    }
                }
            });
        },
        
        commodityInit(){
            jQuery.ajax({
                url:ajaxurl+'?action=market/categorize/index',
                type: 'GET',
                data:{'where':"parent_id IS NULL"},
                dataType:"json",
                 success:(res)=>{
                    if(res.code ==1){
                        this.commodityList = res.data.table;
                    }
                 }
            });
        },
        commodityClick(){
            this.clickType ='commodity';
            this.title ='商品';
            this.show =true;
            this.commodityInit()
        },
        commodityChange(event){
            let value =event.target.value;
          console.log(event.target.value);
          jQuery.ajax({
                url:ajaxurl+'?action=market/categorize/index',
                type: 'GET',
                data:{'where':"parent_id ="+value},
                dataType:"json",
                 success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        // this.commodityList = res.data.table;
                    }
                 }
            });
        },
        commodityUpload(e){
            e.preventDefault();
            let image = wp.media({
                title: '请选择媒体',
                library: {type: 'image'},
                button: {text: '选择'},
                multiple: true
            })
            .open()
            .on('select',()=>{
                console.log(this)
                let images = image.state().get('selection').toArray();
                for(let i =0;i<=(images.length -1);i++){
                    let img_item =(images[i]).toJSON();
                    this.commodity_image.push(img_item) 
                }
            }).on('close',()=>{
                let images = image.state().get('selection').toArray();
                console.log(images.length)
            });
        },
        addCategory(){
            this.modalActive=true;
            this.modalTitle='新增分类';
        },
        submit(){
            if(this.clickType =='swiper'){
               this.swiperSubmit()
            }else if(this.clickType =='notice'){
                this.noticeSubmit()
            }else if(this.clickType =='course'){
                this.courseSubmit()
            }
        }
    },
   //生命周期 - 创建完成
    created() {
       
    },
    updated() {
    },
    //生命周期 - 挂载完成
    mounted() {
        this. pageInit();
       console.log(Vue.options.components)
    }
});
JS;
$this->registerJs($js);

$css=<<<CSS
.editor{
min-height: 300px;
width: 100%;padding: 0px;
border: none; 
outline: none;
border-radius: 0
}
.swiper{
    margin: 10px 5px;
    outline: rgb(195, 196, 199) dashed 3px;
    display: flex;
    flex-wrap: wrap;
    justify-content: left;
    padding: 5px;
}
.swiper img{
    width: 300px;height: 160px;
    margin-left: 10px;
    border:1px solid rgb(220,220,222);
}
.order{
    margin: 0 0;
    border-right:1px solid rgb(220,220,222);
    border-left:1px solid rgb(220,220,222);
    border-top:1px solid rgb(220,220,222);

}
.order-li{
    margin: 0 0;
    border-bottom:1px solid rgb(220,220,222);
}
.order-title{
    margin: 0 0;
    height: 20px;
    text-align: left;
    padding: 10px 10px 11px 14px;
   
}
.order-title:hover{
    background-color: #f6f7f7;
}
.sub-text{
    padding-left: 5px;
    display: inline-block;
    height: 20px;line-height:20px; 
}
.control-section{
    padding: 0;
    border-bottom:1px solid rgb(220,220,222);
}
.accordion-section-content{
 border-top:1px solid rgb(220,220,222);
}
.accordion-section-title{
    padding: 10px 10px 11px 14px;
    
}
.post-body{
    padding: 0 10px;
    border-bottom: 1px solid rgb(220,220,222);
    background-color: white;
}
.post-body-content{
     
    padding: 10px 0;
}
.major-publishing-actions{
    padding: 10px 0;
}
.nav-menu-footer{
    padding: 0 10px;
}
.delete-action{
    float: left; line-height: 2.1;display: inline-block
}
.publishing-action{
    text-align: right;float: right;display: inline-block
}
CSS;
$this->registerCss($css);
