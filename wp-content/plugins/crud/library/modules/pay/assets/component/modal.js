
Vue.component("crud-modal", {
  template: `
<div v-show="active">
    <div tabindex="0" class="media-modal wp-core-ui" role="dialog" aria-labelledby="media-frame-title">
        <div class="media-modal-content" role="document">
            <div class="edit-attachment-frame mode-select hide-menu hide-router">
                <div class="edit-media-header">
                    <button class="left dashicons" @click="next"></button>
                    <button class="right dashicons" @click="previous"></button>
                    <button type="button" class="media-modal-close" @click="close"><span class="media-modal-icon"></span></button>
                </div>
                <div class="media-frame-title"><h1>{{title}} #ID:{{rowId}}</h1></div>
                <div class="media-frame-content">
                    <div class="attachment-details save-ready">
                        <div class="attachment-media-view landscape">
                            <div class="thumbnail">
                             <slot name="left"></slot>
                                <div class="attachment-actions">
                                    <button type="button" class="button button-primary" @click="submit">创建</button>
                                    <button type="button" class="button submit" @click="update">更新</button>
                                    <button type="button" class="button button-link-delete" @click="deleteAll">删除</button>
                                </div>
                            </div>
                        </div>
                        <div class="attachment-info">
                            <slot name="right"></slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="media-modal-backdrop"></div>
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
    rowId:{
      type:Number,
      default: 0
    },
    title:{
      type:String,
      default: 'add'
    }
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
    }
  }
});
