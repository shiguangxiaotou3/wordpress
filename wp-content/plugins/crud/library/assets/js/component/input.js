
// type="text"
// class="regular-text code"
// :disabled="disabled(field.field)"
// :id="tableName +'_' + field.field"
// :name="tableName + '[' + field.field + ']' "
// :value="fieldValue(field)"
Vue.component("crud-input-text", {
    template: `
<input 
    :type="type" 
    :class="inputClass"  
    :style="inputStyle" 
    :disabled="disabled"
    :name="name" 
    :id="id"
    :value="value" 
    :placeholder="placeholder" />
`,
    data(){
        return {}
    },
    computed:{},
    props:{
        value:{
            type:String,
            default: ''
        },
        type:{
            type:String,
            default: 'text'
        },
        disabled:{
          type:Boolean,
          default:false,
        },
        id:{
            type:String,
            default:'',
        },
        inputClass:{
            type:String,
            default: 'regular-text code'
        },
        name:{
            type:String,
            default: ''
        },
        placeholder:{
            type:String,
            default: ''
        },
        inputStyle:{
            type:String,
            default: ''
        },
    },
    methods:{}
});

Vue.component("crud-input-password", {
    template: ``,
    data(){
        return {}
    },
    props:{
        value:{
            type:String,
            default: ''
        },
        type:{
            type:String,
            default: 'text'
        },
        disabled:{
            type:Boolean,
            default:false,
        },
        id:{
            type:String,
            default:'',
        },
        inputClass:{
            type:String,
            default: ''
        },
        name:{
            type:String,
            default: ''
        },
        placeholder:{
            type:String,
            default: ''
        },
        inputStyle:{
            type:String,
            default: ''
        },
    },
    computed: {},
    methods:{}
});