Vue.component("crud-nav-tab-wrapper", {
    template: `
<ul class="nav-tab-wrapper wp-clearfix">
    <a v-for="(item,index ) in links"  :href="prefix+item.url" :class="className(item.url)">{{item.label}}</a>
</ul>`,
    data(){
        return {
        }
    },
    props: {
        'activeUrl': {
            type:String,
            default: ''
        },
        prefix:{
          type:String,
            default: 'admin.php?page='
        },
        links: {
            type:Array,
            default: []
        }
    },
    computed: {},
    methods:{
        className(url){
            return (url == this.activeUrl) ?  'nav-tab nav-tab-active':'nav-tab';
        }
    }
});
