//scope="col"
Vue.component("crud-show-data", {
    template: ``,
    data(){
        return {
            dataType:"text"
        }
    },
    props:{
        dataType:{
            type:String,
            default: 'text'
        },
        value:{
            type:String,
            default: ''
        }
    },
    computed: {
    }
});