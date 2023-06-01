// 菜单组件
Vue.component("content-settings", {
  template: `
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
                {{item.name}}
                <span class="screen-reader-text">按回车来打开此小节</span>
              </h3>
              <div class="accordion-section-content" style="border-bottom: ">
                <ul class="outer-border">
                      <li  v-for="(list,itemIndex) in item.list" :key="itemIndex">
                        <h4 @click.stop="createElement(list,itemIndex)" class="accordion-section-title">{{list.name}}</h4>
                      </li>
                 </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="settings-right"> 
          <div id="dashboard_quick_press" class="postbox" style="width: 562px">
          <div class="postbox-header" >
            <h2 class="hndle ui-sortable-handle" style="padding: 8px 12px;margin: 0;">
              <span class="hide-if-no-js">{{activeTitle}}</span>
              <span class="hide-if-js">您最近的草稿</span>
             </h2>
          </div>
          <div class="inside">
            <div class="canvas" ref="canvas" 
            style=" padding: 10px">
             
            </div>
            <div class="inside drafts" ref="inside" style="">
<!--              <h2 class="hide-if-no-js">样式</h2>-->
<!--              <div class="customlinkdiv" style="padding: 0 18px 13px 13px">-->
<!--                  <p class="wp-clearfix" style="margin-bottom: 13px;">-->
<!--                      <label class="howto" >{{viewId.title}}</label>-->
<!--                      <input v-model:value="viewId.value" :placeholder="viewId.defaultValue" class="regular-text menu-item-textbox" type="text" name="id" >-->
<!--                  </p>-->
<!--              </div>-->
          </div>
          </div>
      </div> 
    </div>
  </div>
</div>`,
  data(){
    return {
      actionMenuIndex: 0,
      settingsMenu: [{
        name: "视图容器",
        title: "导航",
        list: [
          {
            name: "view",
            tag:'div',
            tagOptions:{
              draggable:"true",
              style:
                'height: 30px;'+
                'border:1px solid rgb(220,220,222);'+
                'line-height: 30px;'+
                'padding: 0 10px;'
            },
            title: "View",
            fields: {
              id: {
                value:'',
                title: "Id",
                tag:'input',
                tagOptions:{
                  class: "regular-text code",
                  type:  "text",
                  style: 'margin-left: 10px'
                },
              },
              class: {
                value:'',
                title: "class",
                tag:'input',
                tagOptions:{
                  class: "regular-text code",
                  type:  "text",
                  style: 'margin-left: 10px'
                },
              },
              style: {
                value:'',
                title: "style",
                tag:'input',
                tagOptions:{
                  class: "regular-text code",
                  type:  "text",
                  style: 'margin-left: 10px'
                },
              },
              text:{
                value:'',
                title: "text",
                tag:'input',
                tagOptions:{
                  class: "regular-text code",
                  type:  "text",
                  style: 'margin-left: 10px'
                },
              }
            }
          },
          {
            name: "cover-image",
            tag: "image",
            fields: {
              src: "",
              style: "background-color: red"
            }
          },
          {name: "cover-view", fields: []},
          {name: "grid-view", fields: []},
          {name: "list-view", fields: []},
          {name: "match-media", fields: []},
          {name: "movable-area", fields: []},
          {name: "movable-view", fields: []},
          {name: "page-container", fields: []},
          {name: "root-portal", fields: []},
          {name: "scroll-view", fields: []},
          {name: "share-element", fields: []},
          {name: "sticky-header", fields: []},
          {name: "sticky-section", fields: []},
          {name: "swiper", fields: []},
          {name: "swiper-item", fields: []}
        ]
      }],
      activeList:"",
      activeIndex:'',
      activeTitle:'配置'
    }
  },
  pros:[],
  mounted() {
  },
  methods:{
    showSubMenu(index, e) {
      this.actionMenuIndex = index;
      let li = $(".accordion-container>.outer-border>li:eq(" + index + ")>.accordion-section-content");
      if (li.css("display") === "" || li.css("display") === "none" || li.css("display") === undefined) {
        li.show()
      } else {
        li.hide()
      }
    },
    createElement(list,index){
      this.activeList = list;
      this.activeIndex = index;
      this.activeTitle = list.name;
      this.deleteRef('canvas');
      this.deleteRef('inside');

      // let item = (this.settingsMenu.list)[index]
      const el = new Vue({
        render: h => h(list.tag, {
          attrs: list.tagOptions,
          on: {
            click: () => console.log('clicked'),
            dragstart:this.dragstart,
            mouseover: this.myMouseover,
            mouseleave: this.myMouseleave,
            // dragEnd: this.dragEnd
          }
        }, '这是一个测试元素')
      });

      el.$mount();
      this.$refs.canvas.appendChild(el.$el);

      const h2 = new Vue({
        render: h => h('h2', {
          attrs: {class: "hide-if-no-js",style:'padding: 8px 12px; margin: 0px;font-weight: bold;'}
        }, '属性')
      });
      h2.$mount();

      const content = new Vue({
        render:h=>{
          return  h(
            'div',
            {
              attrs: {class: "customlinkdiv", style: "padding: 0 18px 13px 13px"},
              on: {}
            },
            ((h)=>{
              let fields=[];
              for(let item  in list.fields){
                let name = item;
                let nameOptions = (list.fields)[name];
                let el = h(
                  'p',
                  {
                    attrs: {class: "wp-clearfix", style: "margin-bottom: 13px;"}
                  },
                  [
                    h('label', {
                      attrs: {class: "howto",style:'width: 60px;text-align: right'},
                      on: {}
                    }, nameOptions.title),
                    h(nameOptions.tag||'input', {
                      attrs:nameOptions.tagOptions,
                      domProps: {
                        value: nameOptions.value ||'',
                      },
                      on: {
                        input: event => {
                          console.log( event.target.value)
                          this.activeList.fields[name].value = event.target.value;
                        }
                      }
                    })
                  ]
                )
                fields.push(el)
              }
              return fields;
            })(h)
          )
        }
      })
      content.$mount()

      const event = new Vue({
        render: h => h('h2', {
          attrs: {class: "hide-if-no-js",style:'padding: 8px 12px; margin: 0px;font-weight: bold;'}
        }, '事件')
      });
      event.$mount()

      const eventCallback = new Vue({
        render: h => h(list.tag, {
              attrs: {class: "customlinkdiv", style: "padding: 0 18px 13px 13px"},
              on: {}
            },
            [
              h('p', {
                  attrs: {class: "wp-clearfix", style: "margin-bottom: 13px;"},
                  on: {}
                },
                [
                  h('textarea', {
                    attrs: {class: "large-text code",rows:"5", placeholder:"通知文本" },
                    on: {}
                  })
                ])
            ])
      });
      eventCallback.$mount()

      this.$refs.inside.appendChild(h2.$el);
      this.$refs.inside.appendChild( content.$el);
      this.$refs.inside.appendChild( event.$el);
      this.$refs.inside.appendChild( eventCallback.$el);
    },
    myMouseover(e){
     // 移入
      e.target.style.backgroundColor='rgb(210,210,210)';
      e.target.style.border ='1px solid #2271b1'
    },
    myMouseleave(e){
      // 移出
      e.target.style.backgroundColor =''
      // e.target.style.backgroundColor='rgb(210,210,210)';
      e.target.style.border ='1px solid rgb(220,220,222);'
    },
    deleteRef(ref){
      const inside = (this.$refs)[ref] || '';
      if(inside && inside !='' ){
        while (inside.firstChild) {
          inside.removeChild(inside.firstChild);
        }
      }
    },
    dragstart(e){
      console.log('子 开始拖拽')
      let option={
        tag:this.activeList.tag,
        options:this.activeList.tagOptions
      }
      console.log(option)
      this.$emit('dragstart',option)
    },
    create(){
      console.log(this.$refs.content)
      const el = new Vue({
         render: h => h(this.activeList.tag, {
           attrs: this.activeList.tagOptions,
           on: {
             // click: () => console.log('clicked'),
             // dragstart:this.dragstart,
             // mouseover: this.myMouseover,
             // mouseleave: this.myMouseleave
           }
         }, '这是一个测试元素')
       });
       el.$mount();
       this.$refs.content.appendChild(el.$el);
    }
  }
});
