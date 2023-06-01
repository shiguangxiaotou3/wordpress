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

                    <li class="control-section">
                        <h3 class="accordion-section-title"  @click="is_show=!is_show" tabindex="0">
                            状态栏<span class="screen-reader-text"></span>
                        </h3>
                        <div class="accordion-section-content" :style="(is_show ==false)? 'display: none;':'display: block;'">
                            <div class="inside">
                                <ul class="order">
                                    <li
                                        class="order-li"
                                        v-for="(orderItem,orderIndex) in orderTypeLise"
                                        @click="orderClick(orderIndex)">
                                        <div class="order-title"
                                            :tabindex="orderIndex">
                                            <img style="width: 20px;height: 20px" :src="orderItem.icon">
                                            <div class="sub-text"> {{orderItem.name}}</div>
                                            <code style="background-color:#18bc37;border-radius: 100%;float: right;">{{orderItem.badge}}</code>
                                        </div>
                                    </li>
                                    <li class="order-li">
                                        <div class="order-title"  @click="orderAdd">
                                            <img style="width: 20px;height: 20px" src="/wp-content/uploads/menu/round_add.png">
                                            <div class="sub-text">新增</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                    <li class="control-section" v-for="(group,groupIndex) in severList">
                        <h3 class="accordion-section-title "  @click="groupItemClick(groupIndex)" tabindex="1">
                            分组 {{groupIndex+1}}<span class="screen-reader-text"></span>
                        </h3>
                        <div
                            class="accordion-section-content"
                            :style="(group_is_show[groupIndex] ==false)? 'display: none;':'display: block;'">
                            <div class="inside">
                                <ul class="order">
                                    <li
                                        class="order-li"
                                        v-for="(groupItem,groupItemIndex) in group"
                                        @click="groupItemListClick(groupIndex,groupItemIndex)"
                                        >
                                        <div class="order-title" :tabindex="groupItemIndex">
                                            <img style="width: 20px;height: 20px" :src="groupItem.icon">
                                            <div class="sub-text" > {{groupItem.name}}</div>
                                        </div>
                                    </li>
                                    <li class="order-li">
                                        <div class="order-title" @click="groupItemAdd(groupIndex)">
                                            <img style="width: 20px;height: 20px" src="/wp-content/uploads/menu/round_add.png">
                                            <div class="sub-text" >新增</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <div style="width: 100%;padding: 10px">
                <a class="button submitdelete deletion menu-delete" @click="groupAdd">新增分组</a>
                <a class="button submitdelete deletion menu-delete" @click="deleteGroup"  style="color: #b32d2e;">删除分组</a>
                <a class="button submitdelete deletion menu-delete"  style="color: #00a32a;" @click="submit">提交</a>
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
                        <div class="post-body-content wp-clearfix" >
                            <label class="howto" for="custom-menu-item-url">名称</label>
                            <input  type="text"  ref="name" :value="rowName" class="regular-text" placeholder="名称">
                            <label class="howto" for="custom-menu-item-url">Icons</label>
                            <input type="text"  ref="icons" :value="rowIcons" class="regular-text" placeholder="***.png">
                            <input type="button" name="upload-btn" @click="upload" class="button-secondary" value="选择文件">
                            <div class="icons">
                                <img v-if="rowIcons!=''" :src="rowIcons"  />
                            </div>
                            <label class="howto" for="custom-menu-item-url">Url</label>
                            <input type="text" ref="url" :value="rowUrl" class="regular-text" placeholder="跳转url">
                        </div>
                    </div>
                    <div class="nav-menu-footer">
                        <div class="major-publishing-actions wp-clearfix">
                        <span class="delete-action" style="">
                            <input type="submit" value="删除菜单" class="submitdelete deletion menu-delete" style="color: #b32d2e;" @click="deleteItem"/>
                        </span>
                            <div class="publishing-action" style="">
                                <input type="submit" name="save_menu" @click="save" class="button button-primary button-large menu-save" value="保存菜单">
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
            orderTypeLise:[],
            severList:[],
            is_show:false,
            group_is_show:[],
            n:'',
            subN:'',
            type:'order',
            title:'状态栏'
        }
    }, 
    //监听
    watch: {
        is_show(oldValue,newValue){
            console.log(oldValue,newValue)
        }, 
    },
    //计算属性
    computed: {
        row(){
            if(this.n>=0){
                if(this.type=='order'){
                    if(this.n<= ((this.orderTypeLise.length)-1) ){
                      return (this.orderTypeLise)[this.n]||{}  
                    }
                }else if(this.type=='sever'){
                    if(
                        this.n <= (this.severList.length-1) &&
                        this.subN >=0 &&
                        this.subN <= ((this.severList)[this.n].length)-1
                    ){
                        return (this.severList)[this.n][this.subN]||{}  
                    }
                }
            }
            return false;
        },
        rowName(){
            if(this.row){
                return  this.row.name||""  
            }
            return  ''
          
        },
        rowIcons(){
             if(this.row){
                return  this.row.icon||""  
            }
            return  ''
             return ''// this.row.icon||""  
        },
        rowUrl(){
             if(this.row){
                return  this.row.url||""  
            }
            return  ''
        },
    },
    methods: {
        debug(){
            console.log('n:'+this.n+' subN:'+this.subN+' type:'+this.type) 
        },
        pageInit(){
            jQuery.ajax({
                url:'/wp-json/crud/api/market/index/my',
                type: 'GET',  
                 success:(res)=>{
                    if(res.code ==1){
                        this.orderTypeLise = res.data.orderTypeLise;
                        this.severList = res.data.severList;
                    }
                    this.group_is_show_init()
                 }
            });
        },
        group_is_show_init(){
            let arr =[];
            for (let i =0; i<=this.severList.length-1;i++){
                arr.push(false)
            }
            this.group_is_show= arr;
        },
        
        orderShow(){
            console.log('sads')
            this.is_show =true;
        },
        groupItem_show(index){
           return (this.group_is_show)[index] || true
        },
        
        orderClick(index){
            this.type='order'
            this.n =index
             this.debug()
        },
        groupItemClick(index){
            this.n= index;
            this.type='sever';
            this.title='分组'+(index+1)
            let is_show =(this.group_is_show)[index];
            this.group_is_show.splice(index,1,!is_show)
             this.debug()
        },
        groupItemListClick(groupIndex,groupItemIndex){
             this.type='sever'
             this.n = groupIndex
             this.subN =groupItemIndex;
            this.debug()
        },  
        
        orderAdd(){
            this.type='order'
            this.orderTypeLise.push({
                'name' :'',
                'icon' : '/favicon.ico',
                'badge' : '0',
                'url':''})  
          this.n= this.orderTypeLise.length-1
        },
        groupAdd(){
            this.severList.push([]);
            this.group_is_show.push(true);
            this.type='order';
            this.n=this.severList.length-1;
        },
        groupItemAdd(index){
            this.n =index;
            this.type='sever';
            let item =  (this.severList)[index];
            item.push({
                'name' : '新的列表',
                'icon' : '/favicon.ico',
                'url' : ''
            })
            this.severList.splice(this.n,1,item)
            this.subN =(this.severList)[index].length-1
        }, 
       
        deleteGroup(){
              this.debug()
              if(this.severList.length>=1){
                   if(this.n <= (this.severList.length-1) ){
                        this.severList.splice(this.n,1);
                        this.group_is_show.splice(this.n,1);
                        this.n= this.severList.length-1
                        this.type='server'
                        console.log(this.severList,this.n)
                    }
              }
            this.debug()
        },
        deleteItem(){
            if(this.type=='order'){
               this.orderTypeLise.splice(this.n,1)
            }if(this.type=='sever'){
                 return (this.severList)[this.n].splice(this.subN,1)
            }
        },
        upload(e){
            if(this.row !={} && this.row.icon !=undefined){
               e.preventDefault();
                let image = this.\$wp.media({
                    title: '请选择媒体',
                    multiple: true
                }).open().on('select',()=>{
                    console.log('请选择媒体')
                    console.log(image.state().get('selection').first())
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    if(this.type=='order'){
                        let item = (this.orderTypeLise)[this.n]
                        item .icon =image_url
                        this.orderTypeLise.splice(this.n,1,item)
                    }if(this.type=='sever'){
                        let item = (this.severList)[this.n];
                        let subItem = item[this.subN];
                        subItem .icon =image_url
                        item.splice(this.subN,1,subItem)
                        this.severList.splice(this.n,1,item)
                    }
                 });
            console.log(this.orderTypeLise) 
            }
            
        },
        
        save(){
            let name = this.\$refs.name.value || '';
            let icons = this.\$refs.icons.value || '';
            let url = this.\$refs.url.value || '';
            if(this.type=='order'){
              let item = (this.orderTypeLise)[this.n];
              item.name=name;
              item.icon= icons
              item.url=url
              this.orderTypeLise.splice(this.n,1,item)
            } if(this.type=='sever'){
                let group =(this.severList)[this.n];
                let item = group[this.subN];
                item.name=name;
                item.icon= icons
                item.url=url
                group.splice(this.subN,1,item)
                this.severList.splice(this.n,1,group)
            }
        },
        submit(){
            let fromData ={
                orderTypeLise:this.orderTypeLise,
                severList:this.severList
            }
            jQuery.ajax({
                url:ajaxurl+"?action=market/index/my",
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
        }
    },
   //生命周期 - 创建完成
    created() { 
       
    },
    //生命周期 - 挂载完成
    mounted() {
        this.pageInit()
    }
});
JS;
$this->registerJs($js);



$css=<<<CSS
.icons{
    margin: 10px 5px;
    height: 100px;outline: rgb(195, 196, 199) dashed 3px;
    display: flex;
    justify-content: left;
    padding: 5px;
}
.icons img{
    width: 100px;height: 100px;
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
