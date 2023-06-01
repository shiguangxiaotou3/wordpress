Vue.component("crud-from", {
    template: `
<form :id="tableName" method="post" :action="submitUrl">
  <table class="form-table" role="presentation" v-show="is_show">
      <tbody v-for="(field,index) in columns" >
          <tr v-if="display(field.field)">
              <th scope="row">{{field.title}}</th>
              <td>
                   <crud-input-text
                    type="text"
                    input-class="regular-text code" 
                    :disabled="disabled(field.field)" 
                    :id="tableName +'_' + field.field" 
                    :name="tableName + '[' + field.field + ']' " 
                    :value="fieldValue(field)" />
                   <p v-if="field.error == true" style="color: #cc0000" v-html="field.message"></p>
              </td>
          </tr>
      </tbody>
  </table>
</form>
`,
    data(){
        return {
            is_show:true,
        }
    },
    props:{
        tableName:{
            type:String,
            default: ''
        },
        submitUrl:{
            type:String,
            default:''
        },
        columns:{
            type:Array,
            default:[]
        },
        row:{
            type:Object,
            default:{}
        },
        actionType:{
            type:String,
            default:'add'
        },
        test:{
            type:String,
            default:'add'
        }

    },
    watch: {
        row(){
            if(this.actionType =="add"){
                this.is_show = true;
            }else{
                this.is_show = Object.keys(this.row).length ==0 ? false :true
            }
        }
    },
    computed: {
    },
    methods:{
        fieldValue(field){
            if(this.row){
                if(field.formatter =='datetime'){
                    if((this.row)[field] !==null){
                        return new Date((this.row)[field.field]*1000).format("yyyy-MM-dd hh:mm")
                    }
                }
                return (this.row)[field.field] || ''
            }
        },
        //隐藏字段
        display(field){
            let displayFields =['id','ID','created_at','updated_at'];
            if(this.actionType =='add'){
                if(displayFields.indexOf(field) !=-1){
                    return false
                }
            }
            return true;
        },
        disabled(field){
            if(this.actionType =="view"){
                return true;
            }else if(this.actionType == "edit"){
                let displayFields =['id','ID'];
                if(displayFields.indexOf(field) !=-1){
                    return true
                }
            }else{
                return false
            }

        }
    },
    mounted(){
    }
});