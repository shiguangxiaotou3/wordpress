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
              
              <div class="accordion-section-content" >
                <ul class="outer-border">
                  <draggable v-model="item.list">
                    <transition-group>
                      <li  v-for="(list,itemIndex) in item.list" :key="itemIndex">
                        <h4 @click.stop="createElement(list)" class="accordion-section-title">{{list.name}}</h4>
                      </li>
                    </transition-group>
                  </draggable> 
                 </ul>
            </div>
            
            
          </li>
        </ul>
      </div>
    </div>
    <div class="settings-right">
     <draggable>
     <el-view></el-view>
    </draggable>
      
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
            title: "View",
            fields: {
              id: {defaultValue: "", title: "", inputType: ""},
              class: {defaultValue: "", title: "", inputType: ""},
              style: {defaultValue: "", title: "", inputType: ""}
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
      }]
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
    }
  }
});
