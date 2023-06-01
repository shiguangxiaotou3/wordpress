<?php
/** @var $this yii\web\View */
/** @var $subscription SubscriptionService*/

use crud\modules\wechat\components\SubscriptionService;
use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;

MarketAsset::register($this);
?>
    <div class="wrap" id="app">
        <?= PageHeaderWidget::widget() ?>
        <div class="settings-content" >
            <div class="content-settings"  >
                <div class="settings-content">
                    <div class="settings-left">
                        <!-- 菜单 -->
                        <div class="accordion-container default-border" id="menu"
                             style="outline: rgb(195, 196, 199) dashed 3px;min-height: 200px ">
                            <ul class="outer-border">
                                <li v-for="(template,index) in templates" @click="clickTemplate(index)"
                                    class="control-section" style="padding: 1px 3px" >
                                    <h3 class="accordion-section-title" :tabindex="index"  >
                                        {{template.title}}
                                        <span class="screen-reader-text">按回车来打开此小节</span>
                                    </h3>
                                </li>
                            </ul>
                        </div>
                        <div style="padding: 10px 20px">
                            <input type="button" name="submit"  class="button button-see-me"  value="删除菜单">
                        </div>
                    </div>
                    <div class="settings-right" style="background-color: #FFFFFF">

                        <h1 class="wp-heading-inline" style="padding-left: 15px">参数详情</h1>
                        <hr class="wp-header-end">
                        <!-- 菜单项 -->
                        <table class="form-table" role="presentation" style="background-color: #FFFFFF">
                            <tbody>
                            <tr v-for="(button,index) in model" :key="index">
                                <th scope="row" style="padding-left: 20px">{{button.name}}</th>
                                <td v-if="!inputType(button.name)">
                                    <input :type="inputType(button.name)"
                                           :name="button.name"
                                           :class="'regular-text code'"
                                           :value="button.value"
                                           :placeholder="button.value">
                                    <p v-if="button.description" v-html="button.description"></p>
                                </td>
                                <td v-else>
                                    <textarea :name="button.name"
                                              class="large-text code"
                                              :rows="getStrLine(button.value)"
                                              style="width: 500px"
                                              v-html="button.value">
                                    </textarea>
                                    <p v-if="button.description" v-html="button.description"></p>
                                </td>
                            </tr>
                            <tr v-if="model.length >0">
                                <th scope="row" style="padding-left: 20px">
                                    测试发送
                                    <p>
                                        <input
                                            type="button"
                                            name="send"
                                            @click="sendMessage"
                                            class="button button-see-me"
                                            value="发送">
                                    </p>

                                </th>
                                <td>
                                     <textarea
                                         ref="messageData"
                                         class="large-text code"
                                         :rows="getContentLine"
                                         style="width: 600px"
                                         v-html="getContentJsonStr"
                                     ></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
            templates:[],
            model:{},
            index:0,
            content:{},
            messageData:{}
        }
    },
    //监听
    watch: {
        
    },
    //计算属性
    computed: {
        getContent(){
            return  this.model.find(item => item.name  === 'content') || {};   
        },
        template_id(){
            return (this.templates)[this.index].template_id || ''
        },
        getContentValue(){
             let obj = this.getContent;
             
             let result ={
                 "touser":"OPENID",
                 "template_id":this.template_id,
                 "url":"http://xxx.com/",
                 "miniprogram":{
                    "appid":"xiaochengxuappid12345 ",
                    "pagepath":"index?foo=bar"
                },
                "data":{}
             };
             if(obj.value){
                 const regex = /{{(.*?)}}/g;
                let match;
                while (match = regex.exec(obj.value)) {
                   let key = match[1].split(/\./)[0];
                    result['data'][key]={
                        "value":"",
                       "color":"#173177"
                    }
                }
             }
             return result;
        },
        getContentLine(){
             return this.getStrLine(this.getContentJsonStr)
        },
        getContentJsonStr(){
             return JSON.stringify(this.getContentValue, null, 4)
        }
    },
    //方法
    methods: {
        inputType(fieldName){
           let fields =['content','example']; 
           if(fields.indexOf(fieldName) !=-1){
               return true;
           }
           return  false
        },
        getStrLine(str){
           return  str.split(/\\r\\n|\\r|\\n/).length +1;
        },
        clickTemplate(index){
            if((this.templates)[index]){
                this.index =index;
                this.setModel((this.templates)[index])
                console.log(this. getContentJsonStr)
            }
        },
        setModel(button){
             if(button){
                let arr =[];
                for(var a in button){
                    arr.push({name:a,value:button[a]});
                }
                this.model = arr;
            }
        },
        // 查询当前菜单
        getList(){
            jQuery.ajax({
                url:ajaxurl,
                data:{'action':'wechat/template-message/list'},
                dataType:'json',
                type: 'GET',  
                success:(res)=>{
                    console.log(res)
                    if(res.code ==1){
                        this.templates = res.data.template_list;
                    }
                },
                error:()=>{
                    this.error('查询失败')
                }
            })
        },
        // 设置菜单
        sendMessage(){
            try {
                let value = this.\$refs.messageData.value;
                let json = JSON.parse(value);
                jQuery.ajax({
                    url:ajaxurl,
                    dataTpe:'json',
                    data:{'action':'wechat/template-message/send','message': json },
                    type:'POST',
                    success:(res)=>{
                      console.log(res)
                    },
                    error:(error)=>{
                       this.showError('查询失败')
                    }
                });
            } catch (error) {
                 console.log('格式错误')
            }
            
        },
        deleteTemplate(){
            jQuery.ajax({
                 url:ajaxurl,
                dataTpe:'json',
                data:{'action':'wechat/template-message/delete','button':this.settingsMenu},
                type:'POST',
                success:(res)=>{
                },
                error:(error)=>{
                   this.showError('查询失败')
                }
            });
        }
    },
    //生命周期 - 创建完成
    created() { },
    //生命周期 - 挂载完成
    mounted() { 
        this.getList()
    },
});

JS;
$this->registerJs($js);


