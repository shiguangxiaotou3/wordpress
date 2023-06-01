Vue.component("crud-modal-container", {
    template: `<div v-show="active">
    <div tabindex="0" class="media-modal wp-core-ui" role="dialog" aria-labelledby="media-frame-title">
        <div class="media-modal-content" role="document">
            <div class="edit-attachment-frame mode-select hide-menu hide-router">
                <!-- header -->
                <div class="edit-media-header">
                    <button class="left dashicons"  @click="previous"></button>
                    <button class="right dashicons"  @click="next"></button>
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
                                    <button type="button" class="button" @click="close">关闭</button>
                                    <button type="button" v-show="actionType=='add'" class="button button-primary" @click="submit">创建</button>
                                    <button type="button" v-show="actionType=='edit'"  class="button button-primary" @click="update">更新</button>
                                    <button type="button" v-show="actionType=='edit'"  class="button button-link-delete" @click="deleteAll">删除</button>
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
    data() {
        return {}
    },
    props: {
        active: {
            type: Boolean,
            default: false
        },
        rowId: {
            type: Number,
            default: 0
        },
        title: {
            type: String,
            default: 'add'
        },
        actionType: {
            type: String,
            default: 'add'
        },
    },
    computed: {},
    methods: {
        next(value) {
            this.$emit('next', value)
        },
        previous(value) {
            this.$emit('previous', value)
        },
        close(value) {
            this.$emit('close', value)
        },
        submit(value) {
            this.$emit('submit', value)
        },
        view() {
        },
        update() {
            console.log('upload')
            this.$emit('update')
        },
        deleteAll() {
            this.$emit('delete')
        },
    }
});


Vue.component('crud-modal-mini', {
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
        data() {
            return {}
        },
        props: {
            active: {
                type: Boolean,
                default: false
            },
        },
        computed: {},
        methods: {
            next(value) {
                this.$emit('next', value)
            },
            previous(value) {
                this.$emit('previous', value)
            },
        }
    });

Vue.component('crud-modal', {
    template: `
<div class="notification-dialog-wrap request-filesystem-credentials-dialog" style="display: block;">
  <div class="notification-dialog-background"></div>
  <div class="notification-dialog" role="dialog">
    <div class="request-filesystem-credentials-dialog-content">
        <div class="request-filesystem-credentials-form">
          <h2>{{title}}</h2>
          <slot></slot>
          <p class="request-filesystem-credentials-action-buttons">
                <button class="button cancel-button" v-if="this.$listeners['cancel']" type="button" @click="modalCancel">关闭</button>
                <button class="button" type="button" v-if="this.$listeners['confirm']" @click="modalConfirm">确定</button>
                <button class="button" type="button" v-if="this.$listeners['submit']"  @click="modalSubmit">提交</button>
          </p>
        </div>
    </div>
  </div>
</div>`,
    data() {
        return {}
    },
    props: {
        title:{
            type: String,
            default: '测试弹窗',
        },
        active:{
            type:Boolean,
            default:false
        },
        delay:{
            type:Number,
            default:0
        }
    },
    watch:{
        delay(){
            if(this.active ==false){
                this.active =true;
                setTimeout(()=>{
                    this.active =false;
                },this.delay)
            }
        },
    },
    computed: {},
    methods: {
        modalCancel(event){
            if( this.$listeners['cancel']){
                this.$emit('cancel',event)
            }
        },
        modalConfirm(event){
            if( this.$listeners['confirm']){
                this.$emit('confirm',event)
            }
        },
        modalSubmit(event){
            if( this.$listeners['submit']){
                this.$emit('submit',event)
            }
        }
    },
    // mounted(){
    //     if(this.delay>0){
    //         this.active =true;
    //         setTimeout(()=>{
    //             this.active =false;
    //         },this.delay)
    //     }
    // }
});
