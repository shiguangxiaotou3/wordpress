
Vue.component("crud-tablenav-pages", {
    template: `
<div  class="tablenav top">
     <slot name="buttons"></slot>
    <div class="tablenav-pages">
        <span class="displaying-num">{{total}}个记录</span>
        <span class="pagination-links">
            <button :class="'tablenav-pages-navspan button ' + ((index > 1) ? '' : 'disabled')"  @click="index=1">«</button>
            <button :class="'tablenav-pages-navspan button ' + ((index > 1) ? '' : 'disabled')"  @click="previous">‹</button>
            <span class="paging-input">
                第<label for="current-page-selector" class="screen-reader-text">当前页</label>
                <input class="current-page" id="current-page-selector" type="text" name="paged" :value="index" v-on:input="inputChange" :size="inputSize"  aria-describedby="table-paging">
                <span class="tablenav-paging-text">页,共<span class="total-pages">{{pageSum}}</span>页</span>
            </span>
            <button :class="'next-page button ' + ((index < pageSum) ? '' : 'disabled') " @click="next" >›</button>
            <button :class="'tablenav-pages-navspan button ' + ((index == pageSum) ? 'disabled' : '')  " @click="index=pageSum" >»</button>
        </span>
    </div>
</div>`,
    data(){
        return {
            index:this.page
        }
    },
    props: {
        page: {
            type: Number,
            default: 1
        },
        pageSize: {
            type: Number,
            default: 1
        },
        total: {
            type: Number,
            default: 0
        },
        // buttons:{
        //     type:Array,
        //     default: 0
        // }
    },
    watch:{
        page(value){
            this.index =value;
        },
        index(value){
            this.change(value)
        }
    },
    computed: {
        pageSum(){
            return Math.ceil(this.total / this.pageSize);
        },
        inputSize(){
            return  this.index.toString().length || 1;
        }
    },
    methods:{
        // 点击进入下一页
        next() {
            if (this.index < this.pageSum) {
                this.index++;
            }
        },
        // 点击进入上一页
        previous() {
            if (this.index > 1) {
                this.index--;
            }
        },
        change(value){
            this.$emit('pageChange', value)
        },
        inputChange(e){
            let value =parseInt( e.target.value)
            if(value && value<= this.pageSum){
                this.index = value ;
            }
        }
    }
});
