//scope="col"
Vue.component("crud-columns-thead", {
    template: `
    <th  v-if="display" :id="field.field" :class="className" :style="field.style">
        <template v-if="field.order">
            <a href="">
                <span>{{field.title}}</span>
                <span class="sorting-indicator"></span>
            </a>
        </template>
        <template v-else >
        {{field.title}}
        </template>
    </th>
`,
    data(){
        return {
            className:"manage-column"
        }
    },
    props:{
        field:{
            type:Object,
            default: {}
        }
    },
    computed: {
        display(){
            return this.field.display || true;
        }
    }
});
//field.field +' column-' +field.field

Vue.component("crud-columns-tbody", {
    template: `
<td  
 v-if="display" 
 :class="className" 
 :style="field.style" 
 :data-colname="field.title" 
 xmlns="http://www.w3.org/1999/html">
    <template v-if="isType(field,'json')">
        <button 
            class="button button-small button-link" 
            v-if="(row[field.field] !=null)" 
            :data-value="row[field.field]" 
            @click="showMiniModal(field)">Json</button>
    </template>
    
    <template  v-else-if="isType(field,'url')">
        <input type="text"  :value="row[field.field]" style="display: inline-block;width: 80%">
        <div class="button" @click="copy($event)"  style="padding: 0px;display: inline-block">
            <span class="dashicons dashicons-admin-links" style="margin: 4px 4px"></span>
        </div>  
    </template>
    
    <template v-else-if="isType(field,'timeStamp')" >
        {{format_text(row[field.field])}}
    </template>
   
    
    <template  v-else-if="isType(field,'image')">
        <img :src="row[field.field]" />
    </template>
    
    <template  v-else-if="isType(field,'file')" />
    
    <template  v-else  >{{row[field.field]}}</template>
    
</td>`,
    data(){
        return {
            className:"manage-column"
        }
    },
    props:{
        field:{
            type:Object,
            default: {}
        },
        row:{
            type:Object,
            default: {}
        }
    },
    computed: {
        display(){
            return this.field.display || true;
        }
    },
    methods: {
        format_text(value,format="yyyy-MM-dd hh:mm"){
            return new Date(value*1000).format(format)
        },
        datetime(field,row){
            let value =row[field.field];
            if(value !==null){

                return new Date(value*1000).format("yyyy-MM-dd hh:mm")
            }
        },
        status(field,row){
            let value =row[field.field];
            let list =field.statusList
            return list[value];
        },
        buttons(field,row){
            let value =row[field.field];
            let list =field.buttonsList;
            let html ='';
            for(let i =0;i<=list.length -1;i++){
                let btn =list[i];
                html +=`<button aria-label="\${btn.title}" class="\${btn.classname}" style="margin: 1px;display: inline-block;"><span class="dashicons \${btn.icon}" ></button>`;
            }
            return html;
        },
        formatter(field,row){
            if(field.formatter =='datetime' || field.field=='created_at' || field.field=='updated_at'){
                return this.datetime(field,row)
            }
            if ( field.formatter =='status'){
                return this.status(field,row)
            }
            if ( field.formatter =='buttons'){
                return this.buttons(field,row)
            }
            if(field.dataType=='json'){
                return '<a  href="javascript;" data-value="' + row[field.field] +'">Json</a>'
            }
            return  row[field.field]
        },
        showJson(field){
            let value =(this.row)[field.field] ;
            value = (value !='') ? '{}':value;
            let str = JSON.parse(value);
            let content ='<pre style="text-align:left;width: 100%;height: 100%;">'+
                JSON.stringify(str ,null, 4) + '</pre>';
        },
        showMiniModal(data){
            this.$emit('showMiniModal',data)
        },
        isType(field,type){
            let dataType = field.dataType || '';
            if(dataType !=''){
                return (dataType ==type) ? true: false;
            }
            return false;
        },
        copy(event){
            event.currentTarget.parentElement.firstElementChild.select()
            document.execCommand('copy');
            alert('复制成功');
        }
    }
});

