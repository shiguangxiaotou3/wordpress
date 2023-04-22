Vue.component("crud-crud", {
    template: `
<div class="wrap">
    <h1 class="wp-heading-inline">{{title}}</h1>
    <hr class="wp-header-end">
    <crud-notice 
        :active="notice.active" 
        :noticeType='notice.noticeType' 
        :title="notice.title" 
        :content="notice.content" 
        :close="notice.close">
    </crud-notice>
   
    <crud-nav-tab-wrapper 
        :active-url="activeUrl" 
        :links="links">
    </crud-nav-tab-wrapper>

    <crud-table 
        :tableName="tableOptions.tableName" 
        :page="tableOptions.page" 
        :pageSize="tableOptions.pageSize" 
        :actions="tableOptions.actions" 
        @error="error" 
        @success="success">
    </crud-table>
</div>`,
    data(){
        return {
            notice: {
                active: false,
                noticeType: 'notice-dismiss',
                title: '',
                content: '',
                close: true
            }
        }
    },
    props:{
        title:{
            type:String,
            default: 'Test'
        },
    },
    computed: {
    },
    methods:{
        error(notice){
            this.notice =notice
        },
        success(notice){
            this.notice =notice
        }
    },
    mounted() {
        console.log(this.navTabWrapper)
    }
});