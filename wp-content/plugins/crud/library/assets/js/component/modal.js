
Vue.component("crud-modal-container", {
  template: `<div v-show="active">
    <div tabindex="0" class="media-modal wp-core-ui" role="dialog" aria-labelledby="media-frame-title">
        <div class="media-modal-content" role="document">
            <div class="edit-attachment-frame mode-select hide-menu hide-router">
                <!-- header -->
                <div class="edit-media-header">
                    <button class="left dashicons"  @click="next"></button>
                    <button class="right dashicons"  @click="previous"></button>
                    <button type="button" class="media-modal-close" @click="close">
                        <span class="media-modal-icon"></span>
                    </button>
                </div>
                <div class="media-frame-title"><h1>{{title}}</h1></div>
                <!-- end header -->
                 <!--  content -->
                <div class="media-frame-content">
                    <div class="attachment-details save-ready">
                        <div class="attachment-media-view landscape">
                            <div class="thumbnail">
                                <slot name="left"></slot>
                                <div class="attachment-actions">
                                    <button type="button" v-if="(actionType=='add') ?'true':'false' " class="button button-primary" @click="submit">创建</button>
                                    <button type="button" v-if="((actionType=='edit') || (actionType=='view')) ?'true':'false' "  class="button submit" @click="update">更新</button>
                                    <button type="button" v-if="((actionType=='edit') || (actionType=='view')) ?'true':'false' "  class="button button-link-delete" @click="deleteAll">删除</button>
                                </div>
                            </div>
                        </div>
                        <div class="attachment-info">
                            <slot name="right"></slot>
                        </div>
                    </div>
                </div>
                <!-- end content -->
            </div>
        </div>
    </div>
    <div class="media-modal-backdrop"></div>
</div>`,
  data(){
    return {
    }
  },
  props:{
    active:{
      type:Boolean,
      default: false
    },
    rowId:{
      type:Number,
      default: 0
    },
    title:{
      type:String,
      default: 'add'
    },
    actionType:{
      type:String,
      default: 'add'
    },
  },
  computed:{},
  methods:{
    next(value) {
      this.$emit('next', value)
    },
    previous(value) {
      this.$emit('previous', value)
    },
    close(value){
      this.$emit('close', value)
    },
    submit(value){
      this.$emit('submit', value)
    },
    view(){
    },
    update(){
      this.$emit('update')
    },
    deleteAll(){
      this.$emit('delete')
    },
  }
});


Vue.component(
    'crud-modal-mini',{
    template: `
<div v-show="active">
    <div class="theme-overlay" tabindex="0" role="dialog" aria-label="主题详情">
        <div class="theme-overlay">
            <div class="theme-backdrop"></div>
            <div class="theme-wrap wp-clearfix" role="document">
                <!-- header -->
                <div class="theme-header">
                    <slot name="theme-header"></slot> 
                </div>
                <!-- end header -->
                <!-- content -->
                <div class="theme-about">
                    <slot name="theme-screenshots"></slot>
                    <slot name="theme-info"></slot>
                </div>
                 <!-- end content -->
                <!-- footer -->
                <div class="theme-actions">
                    <div class="active-theme" style="float: right">
                        <slot name="actions-right"></slot>
                    </div>
                    <div class="inactive-theme">
                        <slot name="actions-content"></slot>
                    </div>
                    <slot name="actions-right"></slot>
                </div>
                <!-- end footer -->
            </div>
       </div>
    </div>
</div>
`,
  data(){
    return {
    }
  },
  props:{
    active:{
      type:Boolean,
      default: false
    },
  },
  computed:{},
  methods:{
    next(value) {
      this.$emit('next', value)
    },
    previous(value) {
      this.$emit('previous', value)
    },
  }
});