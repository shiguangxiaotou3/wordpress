Vue.component("crud-notice", {
    template: `
<div id="message" v-if="active" :class="className">
    <p ><strong>{{title}}</strong></p>
    <p v-if="content !==''">{{content}}</p>
    
    <template v-if="messageTimeout >0" />
    
    <template v-else>
        <button 
         type="button" 
         class="notice-dismiss" 
         v-if="close" 
         @click="display"></button>
    </template>
    
</div>`,
    data(){
        return {
            notices:[
                "notice-error",
                "notice-warning",
                "notice-success",
                "notice-dismiss",
                "notice-title",
                "notice-large",
                "notice-alt"
            ],
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
        },
        messageTimeout:0
    },
    computed: {
        className(){
            if(this.messageTimeout >0){
                return this.noticeType +' notice-dismiss notice'
            }else {
                if((new RegExp(/notice\-dismiss/, 'g')).test(this.noticeType)){
                    return this.noticeType +' is-dismissible notice'
                }else {
                    if(this.close){
                        return this.noticeType +' notice is-dismissible'
                    }
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
