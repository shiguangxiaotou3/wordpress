Vue.component("crud-from", {
    template: `
<form :id="tableName" method="post" :action="submitUrl">
  <table class="form-table" role="presentation">
      <tbody v-for="(field,index) in columns" v-if="display(field.field)">
          <tr>
              <th scope="row">{{field.title}}</th>
              <td>
                   <input 
                    type="text"
                    class="regular-text code" 
                    :disabled="disabled(field.field)" 
                    :id="tableName +'_' + field.field" 
                    :name="tableName + '[' + field.field + ']' " 
                    :value="fieldValue(field)">
                   <p v-if="field.error == true" style="color: #cc0000" v-html="field.message"></p>
              </td>
          </tr>
      </tbody>
  </table>
</form>
`,
    data(){
        return {
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
            let displayFields =['id','ID'];
            if(this.actionType =='edit'){
                if(displayFields.indexOf(field) !=-1){
                    return true
                }
            }
            return false
        }
    }
});