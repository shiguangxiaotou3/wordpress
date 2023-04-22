
Vue.component("crud-modal-container", {
  template: `
<div v-show="active">
    <div tabindex="0" class="media-modal wp-core-ui" role="dialog" aria-labelledby="media-frame-title">
        <div class="media-modal-content" role="document">
            <div class="edit-attachment-frame mode-select hide-menu hide-router">
                <div class="edit-media-header">
                    <button class="left dashicons"  @click="next"></button>
                    <button class="right dashicons"  @click="previous"></button>
                    <button type="button" class="media-modal-close" @click="close">
                        <span class="media-modal-icon"></span>
                    </button>
                </div>
                <div class="media-frame-title"><h1>{{title}}</h1></div>
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
    <div class="theme-overlay" tabindex="0" role="dialog" aria-label="主题详情">
        <div class="theme-overlay">
            <div class="theme-backdrop"></div>
            <div class="theme-wrap wp-clearfix" role="document">
            <div class="theme-header">
              <button class="left dashicons dashicons-no"><span class="screen-reader-text">显示上一个主题</span></button>
              <button class="right dashicons dashicons-no disabled" disabled=""><span class="screen-reader-text">显示下一个主题</span></button>
              <button class="close dashicons dashicons-no"><span class="screen-reader-text">关闭详情对话框</span></button>
            </div>
            <div class="theme-about wp-clearfix">
                <div class="theme-screenshots">
                    <div class="screenshot">
                        <img src="https://www.shiguangxiaotou.com/wp-content/themes/hello-elementor/screenshot.png?ver=2.7.1" alt=""></div>
                    </div>
                <div class="theme-info">
                    <h2 class="theme-name">Hello Elementor<span class="theme-version">版本：2.7.1</span></h2>
                    <p class="theme-author">作者：<a href="">Elementor Team</a>\t\t\t\t</p>
                    <p class="theme-description">A plain-vanilla &amp; lightweight theme for Elementor page builder</p>
                    <p class="theme-tags"><span>标签：</span> accessibility-ready、flexible-header、custom-colors、custom-menu、custom-logo、featured-images、rtl-language-support、threaded-comments、translation-ready</p>
                </div>
            </div>
            <div class="theme-actions">
                <div class="active-theme">
                    <a href="" class="button button-primary customize load-customize hide-if-no-customize">自定义</a>
                    <a class="button" href="">小工具</a>
                    <a class="button" href="">菜单</a> 
                    <a class="button hide-if-no-customize" href="">页眉</a> 
                    <a class="button" href="">页眉</a> 
                    <a class="button hide-if-no-customize" href="">背景</a> 
                    <a class="button" href="">背景</a>
                </div>
                <div class="inactive-theme">
                    <a href="" class="button activate" aria-label="启用 Hello Elementor">启用</a>
                    <a href="" class="button button-primary load-customize hide-if-no-customize">实时预览</a>
                </div>
                <a href="" class="button delete-theme" aria-label="删除 Hello Elementor">删除</a>
            </div>
       </div>
    </div>
</div>`

    }
)