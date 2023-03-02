
Vue.component("el-view", {
  data() {
    return {
      title: "View",
      viewId:{value:"",defaultValue: "text", title: "Id"},
      viewClass: {value:"view",defaultValue: "view", title: "Class"},
      viewStyle: {value:"",defaultValue: "padding: 10px 15px;background-color: rgb(246,247,247);border: 1px solid rgb(220,220,222);", title: "Style"},
      tmp:""
    }
  },
  computed: {
  },
  mounted() {
    // let reg = new RegExp( ';' , "g" )
    // this.tmp = this.viewStyle.value.replace(reg,";\n");
  },
  watch: {
    tmp(value){
      this.viewStyle.value = this.stringToLine(value)
    }
  },
  methods: {
    stringToLine(string){
      return  string.replace(new RegExp( '\n' , "g" ),"");
    },
    stringToLines(string){
      return  string.replace(new RegExp( ';' , "g" ),";\n");
    }
  },
  pros: [],
  template: `
<div id="dashboard_quick_press" class="postbox" style="width: 562px">
    <div class="postbox-header">
      <h2 class="hndle ui-sortable-handle" style="padding: 8px 12px;margin: 0;">
        <span class="hide-if-no-js">{{title}}</span>
        <span class="hide-if-js">您最近的草稿</span>
       </h2>
    </div>
    <div class="inside">
      <div class="canvas">
      <draggable>
        <div :id="viewId.value"  :class="viewClass.value"  :style="viewStyle.value" >asd</div>
      </draggable>
      </div>
      <div class="inside drafts">
        <h2 class="hide-if-no-js">样式</h2>
        <div class="customlinkdiv" style="padding: 0 18px 13px 13px">
            <p class="wp-clearfix" style="margin-bottom: 13px;">
                <label class="howto" >{{viewId.title}}</label>
                <input v-model:value="viewId.value" :placeholder="viewId.defaultValue" class="regular-text menu-item-textbox" type="text" name="id" >
            </p>
            <p class="wp-clearfix" style="margin-bottom: 13px;">
                <label class="howto" >{{viewClass.title}}</label>
                <input v-model:value="viewClass.value" :placeholder="viewClass.defaultValue" class="regular-text menu-item-textbox" type="text" name="class" >
            </p>
           <p class="wp-clearfix" style="margin-bottom: 13px;">
                <label class="howto" >{{viewStyle.title}}</label>
                <textarea v-model:value="tmp" :placeholder="stringToLines(viewStyle.defaultValue)" name="style" id="content"  style="width: 100%" class="mceEditor" rows="5" cols="15">{{}}</textarea>
            </p>
        </div>
    </div>
    </div>
</div>`
});
