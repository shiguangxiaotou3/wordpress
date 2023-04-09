<?php
/** @var $this yii\web\View */
/** @var $model crud\modules\pay\models\Order */
/** @var $url string */
/** @var $token  */
/** @var $code  */
use crud\Base;
use crud\widgets\PageHeaderWidget;
use crud\assets\EchartAsset;
use crud\assets\VueAsset;
VueAsset::register($this);
EchartAsset::register($this);
wp_enqueue_media();
$component =['common.js','modal.js','table.js','tablenav-pages.js','notice.js','columns.js','nav-tab-wrapper.js','crud.js'];
$path =Yii::getAlias("@pay/assets/component");
$js ='';
foreach ($component as $item){
    $js .=PHP_EOL.file_get_contents($path."/".$item);
}
?>
    <div class="wrap">
        <h1 class="wp-heading-inline" v-html="title"></h1>
        <hr class="wp-header-end">
        <crud-notice
                :active="notice.active"
                :notice-type='notice.noticeType'
                :title="notice.title"
                :content="notice.content"
                :close="notice.close">
        </crud-notice>

        <crud-nav-tab-wrapper
                :active-url="activeUrl"
                :links="links">
        </crud-nav-tab-wrapper>

        <crud-table
                :default-table-name="tableName"
                :default-page="page"
                :default-page-size="pageSize"
                :default-actions="actions"
                @message="message"
        >
        </crud-table>
    </div>
<?php
$css =<<<CSS
td{
    text-overflow:ellipsis;
    white-space:nowrap;
    overflow:hidden;
    -webkit-line-clamp: 2;
}
CSS;
$this->registerCss($css);
$js .=<<<JS
new Vue({
    el: '.wrap',
    data(){
        return {
            title:'Order',
            activeUrl:'pay/index',
            links:[
                    {url:'pay/index',label:'支付'},
                    {url:'pay/index/alibaba',label:'支付宝'},
                    {url:'pay/index/wechat',label:'微信支付'},
                    {url:'pay/index/test',label:'测试'},
                    {url:'pay/index/remit',label:'转账到支付宝'},
                    {url:'pay/index/order',label:'订单表'}
            ],
            notice:{active:false,noticeType:'notice-success',title:'',content:'',close:true},
            tableName:"Order",
            page:1,
            pageSize:10,
            actions: {
                "init_url": "pay/order/init",
                // 列表数据url
                "index_url": "pay/order/index",
                // 新增数据url
                "add_url": "pay/order/create",
                // 查看数据url
                "view_url": "pay/order/view",
                // 更新数据url
                "update_url": "pay/order/update",
                // 删除数据url
                "delete_url": "pay/order/delete",
                "deletes_url": "pay/order/deletes"
            }
        }
    },
    methods:{
        message(notice){
            this.notice = notice
        }
    }
});
JS;
$this->registerJs($js);
?>
<?php
//
//$columns=json_encode( $model->columns());
//$config = [
//    "page" => 1,
//    'pageSize' => 10,
//    'table' => [],
//    'columns' => $columns,
//    "actions" => [
//        "index_url" => "pay/order/index",
//        "add_url" => "pay/order/create",
//        "view_url" => "pay/order/view",
//        "update_url" => "pay/order/update",
//        "delete_url" => "pay/order/delete"
//    ],
//];
//
//$js =<<<JS
//
//
//Vue.prototype.$ = jQuery;
//Vue.component("my-td", {
//  template: `
//<td  v-html="formatter_text">
//</td>`,
//  data(){
//    return {
//    }
//  },
//  props:[
//     'row','field','my-class','my-style','data-colname'
//  ],
//  //计算属性
//  computed: {
//    formatter_text(){
//       return this.formatter(this.field,this.row)
//    }
//  },
//  methods:{
//     datetime(field,row){
//       let value =row[field.field];
//       if(value !==null){
//         return new Date(value*1000).format("yyyy-MM-dd hh:mm")
//       }
//       // console.log(row[field.field]);
//
//    },
//    status(field,row){
//       let value =row[field.field];
//       let list =field.statusList
//       return list[value];
//    },
//    buttons(field,row){
//        let value =row[field.field];
//        let list =field.buttonsList;
//        let html ='';
//       for(let i =0;i<=list.length -1;i++){
//         let btn =list[i];
//         html +=`<button aria-label="\${btn.title}" class="\${btn.classname}" style="margin: 1px;display: inline-block;"><span class="dashicons \${btn.icon}" ></button>`;
//       }
//       return html;
//    },
//    formatter(field,row){
//      if(field.formatter =='datetime'){
//        return this.datetime(field,row)
//      }else if ( field.formatter =='status'){
//        return this.status(field,row)
//      }else if ( field.formatter =='buttons'){
//        return this.buttons(field,row)
//      }
//      else {
//        return  row[field.field]
//      }
//    }
//  }
//});
//
//new Vue({
//  el: '#app',
//  data:  () =>{
//    return {
//      // 当前页数
//      page: 1,
//      // 总记录数
//      total: 0,
//      // 分页大小
//      pageSize: 10,
//      // 表格数据
//      table: [],
//      // 表格列配置
//      columns: [],
//      // 操作数据的url
//      actions: {
//        "init_url" : "pay/order/init",
//        // 列表数据url
//        "index_url": "pay/order/index",
//        // 新增数据url
//        "add_url" : "pay/order/create",
//        // 查看数据url
//        "view_url" :  "pay/order/view",
//        // 更新数据url
//        "update_url" :  "pay/order/update",
//        // 删除数据url
//        "delete_url" :  "pay/order/delete"
//      }
//    }
//  },
//  //监听
//  watch: {
//    page(page){
//      if(page >= 1 && page<=this.pageSum){
//        this.index(page)
//      }
//
//    }
//  },
//  //计算属性
//  computed: {
//    //总页数
//    pageSum(){
//      return Math.ceil(this.total / this.pageSize);
//    },
//  },
//  //方法
//  methods: {
//    // 点击进入下一页
//    next() {
//      if (this.page < this.pageSum) {
//        this.page++;
//      }
//    },
//    // 点击进入上一页
//    previous() {
//      if (this.page > 1) {
//        this.page--;
//      }
//    },
//    // 更新当前页面
//    inputChange() {
//       this.index();
//    },
//    // 获取table 字段配置
//    init() {
//      this.$.ajax({
//        url: ajaxurl,
//        type: 'GET',
//        data: {
//          action: 'pay/order/init'
//        },
//        dataType: 'json',
//        success: (res) => {
//          console.log(res);
//          if (res.code == 1) {
//            this.page = res.data.page;
//            this.pageSize = res.data.pageSize;
//            this.columns = res.data.columns;
//          }
//        },
//        error: (res) => {
//           console.log(res);
//        }
//      })
//    },
//    index(page){
//      this.$.ajax({
//        url: ajaxurl,
//        type: 'GET',
//        data: {
//          action: this.actions.index_url,
//          page: page||this.page,
//          pageSize: this.pageSize
//        },
//        dataType: 'json',
//        success: (res) => {
//          if (res.code == 1) {
//            // 当前页数
//            this.page = res.data.page +1;
//            // 总记录数
//            this.total = res.data.total;
//            // 分页大小
//            this.pageSize = res.data.pageSize;
//            // 表格数据
//            this.table = res.data.table;
//          }
//        },
//        error: (res) => {
//           console.log(res);
//        }
//      })
//    },
//    add(){
//
//    },
//    view(){
//
//    },
//    update(){
//
//    },
//    delete(){
//
//    },
//  },
//  //生命周期 - 创建完成
//  created() {
//    this.init();
//  },
//  //生命周期 - 挂载完成
//  mounted() {
//     this.index();
//  },
//  //生命周期 - 创建之前
//  beforeCreate() {
//  },
//  //生命周期- 挂载之前
//  beforeMount() {
//  },
//  //生命周期 - 更新之前
//  beforeUpdate() {
//  },
//  //生命周期 - 更新之后
//  updated() {
//  },
//  //生命周期- 销毁之前
//  beforeDestroy() {
//  },
//  //生命周期- 销毁完成
//  destroyed() {
//  },
//  //如果页面有keep-alive 缓存功能，这个函数会触发
//  activated() {
//  }
//});
//JS;
//$this->registerJs($js);