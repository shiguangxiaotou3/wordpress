//scope="col"
Vue.component("crud-columns-thead", {
    template: `
    <th   v-if="display" :id="field.field" :class="className" :style="field.style">
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
            className:""
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
    <td  v-if="display" class=" " :style="field.style" :data-colname="field.title" v-html="formatter(field,row)"></td>`,
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
        format_text(format,value){
            return this.Date.format()
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
            if(field.formatter =='datetime'){
                return this.datetime(field,row)
            }else if ( field.formatter =='status'){
                return this.status(field,row)
            }else if ( field.formatter =='buttons'){
                return this.buttons(field,row)
            } else {
                return  row[field.field]
            }
        }
    }
});


Vue.component("crud-columns-tfoot", {
    template: `
<th scope="col"  v-if="display" :id="field.field" :class="className" :style="field.style">
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
            className:""
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
