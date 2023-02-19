<?php
/** @var $this yii\web\View */


use crud\widgets\PageHeaderWidget;
use crud\assets\VueAsset;
VueAsset::register($this);


$css= <<<CSS
.test-content{
    display: flex;
    margin-top: 20px;
}
.content-phone{
    background-color: #f0f0f1;
    align-content: center;
    padding: 30px;
}
.phone-size{
 margin: 5px auto;
 align-content: center;
 text-align: center;
}
.phone-background-image{
    background-repeat:no-repeat;
    background-image: url("https://www.shiguangxiaotou.com/wp-content/uploads/2023/02/phone.png");
}
.phone{
 background-color: white;
 border-radius: 30px 30px 55px 55px;
 border: 1px solid red;
}
.content-settings{
    flex: 1;
    margin-left: 20px;

}
.settings-content{
    display: flex;
}
.settings-left{
    width: 300px;
}
.settings-right{
    flex: 1;
    margin-left: 20px;
}
.control-section{
    padding: 8px 12px;margin: 0;
}
CSS;
$this->registerCss($css);

?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div class="test-content" id="app">
        <div class="content-phone">
            <div class="phone-size">
                <select id="phone-size" name="phone-size" @change="phoneSize">
                    <option
                        v-for="(item,index) in phones"
                        :value="index"
                    >{{item.name}}</option>
                </select>
            </div>
            <div class="phone-background-image">
                <div class="phone"></div>
            </div>
        </div>
        <div class="content-settings" >
            <div class="setting-title">
                <h2>基础设置</h2>
            </div>
            <div class="settings-content">
                <div class="settings-left" >
                    <div id="side-sortables" class="accordion-container">
                        <ul class="outer-border">
                            <li class="control-section"
                                v-for="(item,index) in settingsMenu"
                                :key="index"
                                @click="showSubMenu(index)">
                                <h3 class="accordion-section-title" :tabindex="index">
                                    {{item.name}}<span class="screen-reader-text">按回车来打开此小节</span>
                                </h3>
                                <div class="accordion-section-content" >
                                    <ul class="outer-border">
                                        <li  v-for="(list,itemIndex) in item.list">
                                            <h4 @click.stop="createElement(list.name,list.fields)" class="accordion-section-title">{{list.name}}</h4>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="settings-right">
                    <div id="dashboard_quick_press" class="postbox">
                        <div class="postbox-header">
                            <h2 class="hndle ui-sortable-handle" style="padding: 8px 12px;margin: 0;">
                                <span class="hide-if-no-js">快速草稿</span>
                                <span class="hide-if-js">您最近的草稿</span>
                            </h2>
                            <div class="handle-actions hide-if-no-js">
<!--                                <button type="button" class="handle-order-higher">-->
<!--                                    <span class="screen-reader-text">上移</span>-->
<!--                                    <span class="order-higher-indicator" ></span>-->
<!--                                </button>-->
<!--                                <span class="hidden">-->
<!--                                    将<span class="hide-if-no-js">快速草稿</span>-->
<!--                                    <span class="hide-if-js">您最近的草稿</span>模块上移一位</span>-->
<!--                                <button type="button" class="handle-order-lower">-->
<!--                                    <span class="screen-reader-text">下移</span>-->
<!--                                    <span class="order-lower-indicator" aria-hidden="true"></span>-->
<!--                                </button>-->
<!--                                <span class="hidden">-->
<!--                                    将<span class="hide-if-no-js">快速草稿</span>-->
<!--                                    <span class="hide-if-js">您最近的草稿</span>模块下移一位</span>-->
                                <button type="button" class="handlediv" aria-expanded="true">
                                    <span class="screen-reader-text">切换面板：
                                        <span class="hide-if-no-js">快速草稿</span>
                                        <span class="hide-if-js">您最近的草稿</span></span>
                                    <span class="toggle-indicator" ></span>
                                </button>
                            </div>
                        </div>
                        <div class="inside">
                            <br class="clear">
                            <div class="drafts">
                                <h2 class="hide-if-no-js">您最近的草稿</h2>
                                <ul>
                                    <li>
                                        <div class="draft-title">
                                            <a href="" aria-label="编辑“（无标题）”">（无标题）</a>
                                            <time datetime="2023-02-15T20:35:25+08:00">2023年 2月 15日</time>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//onmousedown：鼠标按下事件
//onmousemove：鼠标移动事件
//onmouseup：
$js= <<<JS
  const app2 = new Vue({
    el: '#app',
    data: {
      phones:[
        {name:"iPhone SE",width:375,height:667},
        {name:"iPhone XR",width:414,height:896},
        {name:"iPhone 12 Pro",width:390,height:844}
      ],
      actionMenuIndex:"",
      node:"",
      settingsMenu:[{
          name:"视图容器",
          title:"导航",
          list:[
            {
              name:"view",
              fields:{
                id:"",
                class:"",
                // tag:"div",
                style:""
              }
            },
            {
              name:"cover-image",
              tag:"image",
              fields:{
                src:"",
                style:"background-color: red"
              }
            },
            {name:"cover-view",fields:[]},
            {name:"grid-view",fields:[]},
            { name:"list-view",fields:[]},
            { name:"match-media",fields:[]},
            { name:"movable-area",fields:[]},
            { name:"movable-view",fields:[]},
            { name:"page-container",fields:[]},
            { name:"root-portal",fields:[]},
            { name:"scroll-view",fields:[]},
            { name:"share-element",fields:[]},
            { name:"sticky-header",fields:[]},
            { name:"sticky-section",fields:[]},
            { name:"swiper",fields:[]},
            { name:"swiper-item",fields:[]}
          ]
        }
      ],
      phonesIndex:0,
    },
    mounted(){
      this.phoneSize();
    },
    watch:{
      settingsMenu:{
        deep:true,
        handler(){
          console.log(this.settingsMenu);
        }
      }
    },
    methods:{
      phoneSize(){
        let index = $("#phone-size").val();
        this.phonesIndex = index;
        $(".phone").width(this.phones[index].width + "px");
        $(".phone").height(this.phones[index].height + "px");
        let w = (this.phones[index].width /433) * 489;
        let h =  (this.phones[index].height /800) * 922-21
        $(".phone-background-image").css({
          "background-size": w +"px " + h +"px",
          "padding-top": ( this.phones[index].height /(800/60)) + "px",
          "padding-right":( this.phones[index].width /(433/28)) + "px",
          "padding-left": ( this.phones[index].width /(433/28)) + "px",
          "padding-bottom": ( this.phones[index].height /(800/35)) +  "px",
        });
      },
      showSubMenu(index,e){
        this.actionMenuIndex = index;
        var li = $(".accordion-container>.outer-border>li:eq("+ index+")>.accordion-section-content" );
        if(li.css("display") === "" || li.css("display") === "none" || li.css("display") === undefined){
          li.show()
        }else{
          li.hide()
        }
      },
      view(fields){
        var str ="";
        var arr = Object.keys(fields).sort();
        for(let i=0;i<= arr.length-1;i++){
         str += " " + arr[i]+"=\"" + fields[arr[i]]+ "\"";
        }
        $(".settings-right").append(`
        <div  class='menu-item-handle ui-sortable-handle'\${str}>
          <label class='item-title' for='menu-item-checkbox-308'>
            <input id="menu-item-checkbox-308" type="checkbox" class="menu-item-checkbox" data-menu-item-id="308" disabled="disabled">
            <span class="menu-item-title">插件</span>
            <span class="is-submenu" style="display: none;">子项目</span>
	      </label>
          </div>`);
      },
      createElement(tagName,fields){
        switch(tagName){
          case "view":
            this.view(fields)
            break;
        }
      }
    }
  });
JS;
$this->registerJs($js);
//$arr =wp_styles();
//dump( $arr  );