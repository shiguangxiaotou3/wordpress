Vue.component("crud-notice", {
    template: `
<div id="message" v-if="active" :class="className">
    <p ><strong>{{title}}</strong></p>
    <p v-if="content !==''">{{content}}</p>
    <button v-if="close" type="button" class="notice-dismiss" @click="display" ></button>
</div>`,
    data(){
        return {
            notices:[ "notice-error", "notice-warning", "notice-success", "notice-dismiss", "notice-title", "notice-large", "notice-alt"],
            // active:false,
        }
    },
    props:{
        active:{
            type:Boolean,
            require:true,
            default: false
        },
        noticeType:{
            type:String,
            default: 'notice-success'
        },
        title:{
            type:String,
            default: 'Success'
        },
        content:{
            type:String,
            default: ''
        },
        close:{
            type:Boolean,
            default: true
        }
    },
    computed: {
        className(){
            if((new RegExp(/notice\-dismiss/, 'g')).test(this.noticeType)){
                return this.noticeType +' is-dismissible notice'
            }else {
                if(this.close){
                    return this.noticeType +' notice is-dismissible'
                }
            }
        }
    },
    methods:{
        display(){
            this.active =false
        }
    }
});
