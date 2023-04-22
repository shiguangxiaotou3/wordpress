<?php
/** @var $this yii\web\View */
/** @var $subscription SubscriptionService*/

use crud\modules\wechat\components\SubscriptionService;
use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;

MarketAsset::register($this);
?>
    <div class="wrap" id="app">
        <div v-show="msgSuccess" class="notice notice-success settings-success is-dismissible">
            <p><strong v-html="message"></strong></p>
            <button type="button" @click="msgSuccess =false" class="notice-dismiss"><span class="screen-reader-text" >忽略此通知。</span></button>
        </div>
        <div v-show="msgError" class="notice notice-error settings-error is-dismissible">
            <p><strong v-html="message"></strong></p>
            <button type="button" @click="msgError =false" class="notice-dismiss"><span class="screen-reader-text" >忽略此通知。</span></button>
        </div>
        <?= PageHeaderWidget::widget() ?>
        <div class="settings-content" >


            <div class="content-settings"  >

                <div class="settings-content">
                    <div class="settings-left">
                        <!-- 菜单 -->
                        <div class="accordion-container default-border" id="menu"
                             style="outline: rgb(195, 196, 199) dashed 3px;min-height: 200px ">
                            <ul class="outer-border">
                                <draggable
                                    :anmition="500"
                                    @add="addMenu"
                                    @end="removeMenu"
                                    :group="groupSettings" >
                                    <transition-group>
                                        <li class="control-section"
                                            v-for="(item,buttonIndex) in settingsMenu"
                                            :key="buttonIndex"

                                            @click="showSubMenu(buttonIndex,'menu',$event)">
                                            <h3 class="accordion-section-title" :tabindex="buttonIndex">
                                                {{item.name}}
                                                <span class="screen-reader-text">按回车来打开此小节</span>
                                            </h3>
                                            <div class="accordion-section-content" >
                                                <!-- 子菜单菜单 -->
                                                <ul class="outer-border" >
                                                    <draggable
                                                        :anmition="500"
                                                        @add="addSubMenu"
                                                        @end="removeSubMenu"
                                                        :group="groupSubSettings" >
                                                        <transition-group>
                                                            <li  v-for="(list, itemIndex) in item.sub_button.list" :key="itemIndex">
                                                                <h4
                                                                    @click.stop="showSubMenu(itemIndex,'submenu',$event)"
                                                                    style="margin: 5px 0px;padding: 10px 10px 11px 14px;background-color: rgb(240,240,241)">
                                                                    {{list.name}}
                                                                </h4>
                                                            </li>
                                                        </transition-group>
                                                        <li slot="footer" v-if="item.sub_button.list.length ==0">
                                                            <h4 style="color: #2271b1;outline: rgb(195, 196, 199) dashed 1px;margin: 5px 0px;padding: 10px 10px 11px 14px;">
                                                                菜单拖拽此
                                                            </h4>
                                                        </li>
                                                    </draggable>
                                                </ul>
                                            </div>
                                        </li>
                                    </transition-group>
                                    <li slot="footer" v-if="settingsMenu.length <2" class="control-section">
                                        <h3 class="accordion-section-title"
                                            style="color: #2271b1;outline: rgb(195, 196, 199) dashed 2px;background-color: #fff;margin: 5px 0px;padding: 10px 10px 11px 14px;">
                                            菜单拖拽此
                                        </h3>
                                    </li>
                                </draggable>
                            </ul>
                        </div>
                        <div style="padding: 10px 20px">
                            <input type="button" name="submit"  class="button button-primary" @click="setMenu" value="提交">
                            <input type="button" name="submit"  class="button button-primary" @click="deleteServerMenu" value="重置">
                            <input type="button" name="submit"  class="button button-see-me" @click="deleteMenu" value="删除菜单">
                        </div>
                    </div>
                    <div class="settings-right">
                        <!-- 菜单项 -->
                        <div  class="accordion-container" id="buttons" style="display: flex;">
                            <div style="width: 300px">
                                <ul class="outer-border" style="min-height: 40px">
                                    <draggable
                                        v-model="buttons"
                                        :anmition="500"
                                        draggable="li"
                                        :group="groupButtons" >
                                        <transition-group>
                                            <li class="control-section" style="padding: 2px"
                                                v-for="(item,index) in buttons"
                                                :key="index"
                                                @click="showSubMenu(index,'buttons')">
                                                <h3 class="accordion-section-title" :tabindex="index">
                                                    {{item.name}}
                                                    <span class="screen-reader-text">按回车来打开此小节</span>
                                                </h3>
                                            </li>
                                        </transition-group>
                                    </draggable>
                                </ul>
                            </div>
                            <div style="flex: 1;margin-left: 10px">
                                <table class="form-table" role="presentation" style="background-color: #FFFFFF">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="padding-left: 20px">
                                                <h4>参数设置</h4>
                                            </th>
                                            <td></td>
                                        </tr>
                                        <tr v-for="(button,index) in model" :key="index">
                                            <th scope="row" style="padding-left: 20px">{{button.name}}</th>
                                            <td>
                                                <input type="text"
                                                       name="button.name"
                                                       :class="button.name !=='type' ? 'regular-text code disabled' :'regular-text code'"
                                                       :readonly="button.name !=='type'? false : 'readonly'"
                                                       :value="button.value"
                                                       @input="inputChange(button.name,index,$event)"
                                                       :placeholder="button.value">
                                                <p v-if="button.description" v-html="button.description"></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php


$js =<<<JS
const app2 = new Vue({
    el: '#app',
    data(){
        return {
            buttons:[
                {
                    "name":"一级菜单",
                    "sub_button":{"list":[]}
                },
                {
                    "type":"view",
                    "name":"打开网页",
                    "url":"https://www.shiguangxiaotou.com",
                    "sub_button":{"list":[]}
                },
                {
                    "type":"miniprogram",
                    "name":"打开小程序",
                    "url":"http://mp.weixin.qq.com",
                    "appid":"wx286b93c14bbf93aa",
                    "pagepath":"pages/lunar/index",
                    "sub_button":{"list":[]}
                },
                {
                    "type":"click",
                    "name":"点击",
                    "key":"V1001_GOOD",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "scancode_waitmsg",
                    "name": "扫码带提示",
                    "key": "rselfmenu_0_0",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "scancode_push",
                    "name": "扫码推事件",
                    "key": "rselfmenu_0_1",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "pic_sysphoto",
                    "name": "系统拍照发图",
                    "key": "rselfmenu_1_0",
                    "sub_button":{"list":[]}
                    
                },
                {
                    "type": "pic_photo_or_album",
                    "name": "拍照或者相册发图",
                    "key": "rselfmenu_1_1",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "pic_weixin",
                    "name": "微信相册发图",
                    "key": "rselfmenu_1_2",
                    "sub_button":{"list":[]}
                },
                {
                    "name": "发送位置",
                    "type": "location_select",
                    "key": "rselfmenu_2_0",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "media_id",
                    "name": "图片",
                    "media_id": "MEDIA_ID1",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "view_limited",
                    "name": "图文消息",
                    "media_id": "MEDIA_ID2",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "article_id",
                    "name": "发布后的图文消息",
                    "article_id": "ARTICLE_ID1",
                    "sub_button":{"list":[]}
                },
                {
                    "type": "article_view_limited",
                    "name": "发布后的图文消息",
                    "article_id": "ARTICLE_ID2",
                    "sub_button":{"list":[]}
                }
            ],
            settingsMenu:[
            ],
            obj:'',
            objId:'',
            message:'',
            msgSuccess:false,
            msgError:false,
            clickButton:0,
            clickSubButton:0,
            tmp:{},
            model:[],
            index:0,
            dome:window.ajaxurl,
            groupSettings:{
                name:'submenu1',
                //拖出
                 pull:true,
                // 拖入
                put:(res)=>{
                    if(this.settingsMenu.length >2){
                        this.showError('最多包括3个一级菜单')
                        return false;
                    }else if(this.msgError ){
                        return false;
                    }
                     return true;
                }
            },
            groupSubSettings:{
                name:'submenu2',
                //拖出
                pull:false,
                // 拖入
                put:(res)=>{
                    if((this.settingsMenu)[this.clickButton]['sub_button']['list'].length >4){
                        this.showError('最多包括5个一级菜单')
                        return false;
                    }
                    return true
                }
            },
            groupButtons:{
                name:'submenu3',
                 //拖出
                pull:'clone',
                // 拖入
                put:false
              
            }
        }
    },
    //监听
    watch: {
        
    },
    //计算属性
    computed: {
        
    },
    //方法
    methods: {
        deleteMenu(){
         (this.settingsMenu).splice(this.clickButton,1)
        },
        deleteServerMenu(){
            jQuery.ajax({
                url:this.dome,
                dataTpe:'json',
                data:{'action':'wechat/menu/delete-menu'},
                type:'POST',
                success:(res)=>{
                    console.log(res)
                    this. settingsMenu=[]
                },
                error:(error)=>{
                   this.showError('查询失败')
                }
            });
        },
        addMenu(e){
         if(this.settingsMenu.length >2){
            this.showError('最多包括3个一级菜单')
            return ;
         }
          let  button = (this.buttons)[e.oldIndex];
         button.sub_button.list =[]
          this.settingsMenu.push(button)
        },
        addSubMenu(e){
            let  button = (this.buttons)[e.oldIndex];
            (this.settingsMenu)[this.clickButton].sub_button.list.splice(e.newIndex,0,button)
        },
        removeMenu(e){
            console.log(e.oldIndex);
            console.log(e.newIndex);
        },
        removeSubMenu(e){
             ((this.settingsMenu)[this.clickButton]).sub_button.list.splice(e.oldIndex,1)
        },
        // 查询当前菜单
        selectMenu(){
            jQuery.ajax({
                url:ajaxurl,
                data:{'action':'wechat/menu/get-menu'},
                dataType:'json',
                type: 'GET',  
                success:(res)=>{
                    console.log(res)
                    // if(res.is_menu_open ==1){
                        let button = JSON.parse(JSON.stringify(res.selfmenu_info.button));
                        for(let i =0;i<=(button.length -1);i++){
                            if(!(button[i]['sub_button'] !=undefined)){
                                button[i]['sub_button']  ={'list':[]}
                            }
                            if(!(button[i]['sub_button']['list'] !=undefined)){
                                 button[i]['sub_button']['list']  =[]
                            }
                        }
                        this.settingsMenu =button;
                    // }
                    
                },
                error:()=>{
                    this.error('查询失败')
                }
            })
        },
        // 设置菜单
        setMenu(){
            jQuery.ajax({
                url:this.dome,
                dataTpe:'json',
                data:{'action':'wechat/menu/set-menu','button':this.settingsMenu},
                type:'POST',
                success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        this.showSuccess('设置成功')
                    }else {
                        this.showError(res.message)
                    }
                },
                error:(error)=>{
                   this.showError('查询失败')
                }
            });
        },
        setModel(){
           let button = this.tmp;
             if(button){
                let arr =[];
                for(var a in button){
                    if(a !="sub_button"){
                        arr.push({name:a,value:button[a]});
                    }
                }
                this.model = arr;
            }
        },
       
        inputChange(name,index,e){
            let value = e.currentTarget.value
            if(name !='type'){
                if(this.obj =='buttons'){
                    let item = (this.buttons)[this.objId]
                    item[name] =value;
                }else if(this.obj =='menu'){
                    let item = (this.settingsMenu)[this.clickButton];
                    item[name] =value;
                }else if(this.obj ='submenu'){
                    let item =( (this.settingsMenu)[this.clickButton].sub_button.list)[this.objId];
                    item[name] =value;
                }
                (this.model)[index].value =value
            }
          
        },
        // 现实菜单子项
        showContent(event){
            let content =event.currentTarget.lastElementChild;
            
            if(content.style.display =='' ||content.style.display =='none'){
                content.style.display ='block'
            }else {
                 content.style.display ='none'
            }
        },
        showSubMenu(index, id,event) {
            if(id =='buttons'){
                this.tmp = (this.buttons)[index]
                this.obj ='buttons';
                 this.setModel()
            }else if(id=='menu'){
                this.obj ='menu';
                this.tmp = (this.settingsMenu)[index]
                this.setModel()
                let title = event.currentTarget.firstElementChild
                this.clickButton =index;
                if( title.style.backgroundColor !=='rgb(220,220,220)'){
                     title.style.backgroundColor= 'rgb(220,220,220)'
                }else{
                     title.style.backgroundColor= ''
                }
                this.showContent(event)
            }else if(id =='submenu'){
                 this.obj ='submenu';
                 this.tmp =(this.settingsMenu)[this.clickButton].sub_button.list[index];
                  this.setModel()
            }
            this.objId =index;
        },
       
        showSuccess(message){
            this.msgSuccess =true;
            this.message = message;
        },
        showError(message){
            this.msgError =true;
            this.message = message;
        }
    },
    //生命周期 - 创建完成
    created() { },
    //生命周期 - 挂载完成
    mounted() { 
        this.selectMenu()
    },
});

JS;
$this->registerJs($js);


