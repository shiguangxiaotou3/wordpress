
<?php
/** @var $this yii\web\View */


use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;
MarketAsset::register($this);
wp_enqueue_media();
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
                                        <li class="order-li">
                                            <div class="order-title">
                                                <div class="sub-text">通知</div>
                                            </div>
                                        </li>
                                        <li class="order-li">
                                            <div class="order-title">
                                                <div class="sub-text">仓库</div>
                                            </div>
                                        </li>
                                        <li class="order-li">
                                            <div class="order-title">
                                                <div class="sub-text">教程中心</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <!-- end 首页 -->
                    </ul>

                </div>
                <div style="width: 100%;padding: 10px">
                    <a class="button submitdelete deletion menu-delete"
                       @click="addPage">新增页面
                    </a>
                    <a class="button submitdelete deletion menu-delete"
                       @click="deletePage"
                       style="color: #b32d2e;">删除页面

                    </a>
                    <a class="button submitdelete deletion menu-delete"
                       style="color: #00a32a;"
                       @click="submit">提交</a>
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
                            <div class="post-body-content wp-clearfix">

                                <template v-if="swiper_show">
                                    <div class="drag-instructions post-body-plain">
                                        <p >轮播头图片比例w:h=15:8 <br>其他尺寸或导致变形</p>
                                    </div>
                                    <input
                                        type="text"
                                        ref=""
                                        :value="imagesStr"
                                        class="regular-text"
                                        placeholder="***.png">
                                    <input
                                        type="button"
                                        name="upload-btn"
                                        @click="upload"
                                        class="button-secondary"
                                        value="选择文件">
                                    <div class="swiper">
                                        <img
                                            v-for="(image,index) in swiper.list"
                                            @click="swiper.list.splice(index,1)"
                                            :src="image" />
                                    </div>
                                    <label class="howto" for="custom-menu-item-url">是否显示面板指示点</label>
                                    <input
                                        type="text"
                                        ref="indicatorDots"
                                        v-model="swiper.indicatorDots"
                                        class="regular-text"
                                        placeholder="名称">
                                    <label class="howto" for="custom-menu-item-url">自动播放</label>
                                    <input
                                        type="text"
                                        ref="autoplay"
                                        v-model="swiper.autoplay"
                                        class="regular-text"
                                        placeholder="true">
                                    <label class="howto" for="custom-menu-item-url">播放间隔(毫秒)</label>
                                    <input
                                        type="text"
                                        ref="interval"
                                        v-model="swiper.interval"
                                        class="regular-text"
                                        placeholder="true">
                                    <label class="howto" for="custom-menu-item-url">动画时长(毫秒)</label>
                                    <input
                                        type="text"
                                        ref="auration"
                                        v-model="swiper.auration"
                                        class="regular-text"
                                        placeholder="true">
                                </template>
                            </div>
                        </div>
                        <div class="nav-menu-footer">
                            <div class="major-publishing-actions wp-clearfix">
                                <span class="delete-action" style="">
                                    <input
                                        type="submit"
                                        value="删除菜单"
                                        class="submitdelete deletion menu-delete"
                                        style="color: #b32d2e;"
                                        @click="deleteItem"/>
                                </span>
                                <div class="publishing-action" style="">
                                    <input
                                        type="submit"
                                        @click="save"
                                        class="button button-primary button-large menu-save"
                                        value="保存菜单"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$js =<<<JS
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
                list:[
                    "https://www.shiguangxiaotou.com/wp-content/uploads/2023/02/test-1.webp",
                    "https://www.shiguangxiaotou.com/wp-content/uploads/2023/02/test-1.webp",
                    "https://www.shiguangxiaotou.com/wp-content/uploads/2023/02/test-1.webp"
                ],  
            },
            swiper_show:false,
            title:'状态栏'
        }
    }, 
    //监听
    watch: {
        clickType(oldValue,newValue){
            console.log(oldValue,newValue)
        },
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
                url:ajaxurl+"?action=market/index/page",
                type: 'POST',
                data:{'swiper':this.swiper},  
                 success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        // this.orderTypeLise = res.data.orderTypeLise;
                        // this.severList = res.data.severList;
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
            // let name = this.\$refs.name.value || '';
            // let icons = this.\$refs.icons.value || '';
            // let url = this.\$refs.url.value || '';
            // if(this.type=='order'){
            //   let item = (this.orderTypeLise)[this.n];
            //   item.name=name;
            //   item.icon= icons
            //   item.url=url
            //   this.orderTypeLise.splice(this.n,1,item)
            // } if(this.type=='sever'){
            //     let group =(this.severList)[this.n];
            //     let item = group[this.subN];
            //     item.name=name;
            //     item.icon= icons
            //     item.url=url
            //     group.splice(this.subN,1,item)
            //     this.severList.splice(this.n,1,group)
            // }
        },
        swiperClick(){
          this.clickType ='swiper';
          this.title ='轮播图';
          this.swiper_show =!(this.swiper_show);
        },
        swiperUpload(e){
            e.preventDefault();
                let image = this.\$wp.media({
                    title: '请选择媒体',
                    multiple: true
                }).open().on('select',()=>{
                    let uploaded_image = image.state().get('selection').first();
                    let image_url = uploaded_image.toJSON().url;
                    this.swiper.list.push(image_url) 
                 });
        },
        swiperSubmit(){
            let fromData ={
                orderTypeLise:this.orderTypeLise,
                severList:this.severList
            }
            jQuery.ajax({
                url:ajaxurl+"?action=market/index/page",
                type: 'POST', 
                data:fromData,
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
        
        upload(e){
            if(this.clickType =='swiper'){
               this.swiperUpload(e)
            }
        },
        submit(){
            if(this.clickType =='swiper'){
               this.swiperSubmit()
            }
            // let fromData ={
            //     orderTypeLise:this.orderTypeLise,
            //     severList:this.severList
            // }
            // jQuery.ajax({
            //     url:ajaxurl+"?action=market/index/my",
            //     type: 'POST', 
            //     data:fromData,
            //     dataType:'json',
            //      success:(res)=>{
            //         console.log(res)
            //         if(res.code ==1){
            //             alert('提交成功')
            //         }else {
            //              alert('提交失败')
            //         }
            //      }
            // });
        }
    },
   //生命周期 - 创建完成
    created() { 
       
    },
    //生命周期 - 挂载完成
    mounted() {
    }
});
JS;
$this->registerJs($js);

$css=<<<CSS
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
