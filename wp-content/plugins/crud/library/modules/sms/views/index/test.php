<?php
/** @var $this yii\web\View */
use crud\widgets\PageHeaderWidget;
use yii\helpers\Html;
use crud\assets\VueAsset;
use crud\assets\LayuiAsset;
$sms = Yii::$app->smsComponent;
$country=json_encode( $sms->getCountry());
$server = json_encode( $sms ->getService());
VueAsset::register($this);
LayuiAsset::register($this)
?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div   id="app">
        <div class="tablenav top">
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">服务商</label>
                <select name="action" id="servers">
                    <option   value="">服务商</option>
                    <option  v-for="(server,index) in servers" :key="index" :value="server.code">{{server.name}}</option>
                </select>
                <input type="submit" id="doaction" @click="serverSelect" class="button action" value="应用">
            </div>
            <div class="alignleft actions">
                <label for="filter-by-date" class="screen-reader-text">地区国家</label>
                <select name="m" id="country" >
                    <option selected="selected" value="0">全部地区</option>
                    <option v-for="(country,index2) in countrys " :key="index2" :value="country.id">{{country.chn}}</option>
                </select>
<!--                <label class="screen-reader-text" for="cat">按分类筛选</label>-->
<!---->
<!--                <select name="cat" id="cat" class="postform">-->
<!--                    <option value="0">所有分类</option>-->
<!--                    <option class="level-0" value="10">css</option>-->
<!--                </select>-->
                <input type="submit" name="filter_action" id="post-query-submit" @click="countrySelect" class="button" value="筛选">
            </div>

            <h2 class="screen-reader-text">文章列表导航</h2>
            <div class="tablenav-pages">
                <span class="displaying-num">{{total}}个记录</span>
                <span class="pagination-links">
                    <button :class="'tablenav-pages-navspan button ' + ((page > 1) ? '' : 'disabled')"  @click="page=1">«</button>
                    <button :class="'tablenav-pages-navspan button ' + ((page > 1) ? '' : 'disabled')"  @click="previous">‹</button>
                    <span class="paging-input">
                        第<label for="current-page-selector" class="screen-reader-text">当前页</label>
                        <input class="current-page" id="current-page-selector" type="text" name="paged" v-bind:value="page" v-on:input="inputChange" size="2"  aria-describedby="table-paging">
                        <span class="tablenav-paging-text">页,共<span class="total-pages">{{pageSum}}</span>页</span>
                    </span>
                    <button :class="'next-page button ' + ((page < pageSum) ? '' : 'disabled') " @click="next" >›</button>
                    <button :class="'tablenav-pages-navspan button ' + ((page == pageSum) ? 'disabled' : '')  " @click="page=pageSum" >»</button>

                </span>
            </div>
            <br class="clear">
        </div>
        <h2 class="screen-reader-text">文章列表</h2>
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <template v-for="(th,index3) in columns" >
                        <th v-if="th.order" scope="col" :id="th.field" class="manage-column">
                            <a href="">
                                <span>{{th.title}}</span>
                                <span class="sorting-indicator"></span>
                            </a>
                        </th>
                        <th v-else="" scope="col" :id="th.field" class="manage-column">{{th.title}}</th>
                    </template>
                </tr>
            </thead>
            <tbody id="the-list">
                <tr v-for="(tr,indexTr) in table.slice(beginNumber,endNumber)" :id="'post'+indexTr">
                    <th scope="row" class="check-column">
                        <label class="screen-reader-text" for="cb-select-1">选择</label>
                        <input id="cb-select-1" type="checkbox" name="post[]" value="1">
                        <div class="locked-indicator">
                            <span class="locked-indicator-icon" aria-hidden="true"></span>
                        </div>
                    </th>
                    <td v-for="(field,index) in columns" :class="field.title +' column-' +field.title "
                        :data-colname="tr[field.title]">
                        {{tr[field.field]}}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <template v-for="(th1,index1) in columns" >
                        <th v-if="th1.order" scope="col"  :id="th1.field" class="manage-column">
                            <a href="">
                                <span>{{th1.title}}</span>
                                <span class="sorting-indicator"></span>
                            </a>
                        </th>
                        <th v-else=""  scope="col" :id="th1.field" class="manage-column">{{th1.title}}</th>
                    </template>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<?php
$js = <<<JS
Vue.prototype.$ = jQuery;
const app2 = new Vue({
  el: '#app',
  data: {
    http:{
	  common:{
          baseUrl:"/wp-admin/admin-ajax.php",
          data:{},
          header:{"Content-Type":"application/json","Content-Type":"application/x-www-form-urlencoded"},
          method:"GET",
          dataType:"json"
      },
	  request(options={}){
		options.url = this.common.baseUrl + options.url;
		options.data = options.data || this.common.data;
		options.header = options.header || this.common.header;
		options.method = options.method || this.common.method;
		options.dataType = options.dataType || this.common.dataType;
		options.enableCookie = options.enableCookie || this.common.enableCookie;
		options.withCredentials = options.withCredentials || this.common.withCredentials;
		return new Promise((resolve, reject)=>{
			$.ajax({
                ...options,
                success:(reslut)=>{
                  resolve(reslut.data);
                },
                error:()=>{
                  return reject();
                }
			});
		})
	  }
    },
    servers:{$server},
    countrys:{$country},
    page:1,
    pageSize:10,
    table:{$server},
    columns:[
      {field:"name",title:"名称",order:""},
      {field:"code",title:"代码",order:""},
      {field:"img",title:"图片",order:""}
    ]
  },
  //监听
  watch: {},
  //计算属性
  computed: {
    // 总记录数
    total(){
      return this.table.length;
    },
    // 总页数
    pageSum(){
      return Math.ceil(this.total / this.pageSize);
    },
    beginNumber(){
      return ((this.page -1) * this.pageSize );
    },
    endNumber(){
      let i =this.page* this.pageSize -1;
      if(i < this.total){
       return i;
      }else{
        return this.total;
      }
    }
  },
  //方法
  methods: {
   next(){
     if(this.page < this.pageSum){
       this.page ++;
     }
   },
   previous(){
     if(this.page > 1){
       this.page --;
     }
   },
   getServerName(code){
       for(let i =0;i<= this.servers.length-1;i++){
       let item =(this.servers)[i];
       if( item.code  == code){
         return item;
       }
     }
     return false;
   },
   getCountryName(id){
     for(let i =0;i<= this.countrys.length-1;i++){
       let item =(this.countrys)[i];
       if( item.id  == id){
         return item;
       }
     }
     return false;
   },
   inputChange(e){
     console.log(e.target.vaule);
     this.page =e.target.vaule;
   },
   serverSelect(){
       let servers =$("#servers").val();
       this.http.request({
        url:"",
        data:{
           "action":"sms/index/select",
           "crud":"getTopCountriesByService",
           "service": servers,
            "freePrice":true
         },
       method:"POST"
    }).then((res)=>{
      console.log(res)
      let table =[];
      for(let i =0;i<= res.length -1;i++){
        table.push({
          count:res[i]['count'],
          country:res[i]['country'],
          price:res[i]['price'],
          retail_price:res[i]['retail_price'],
          countryName:this.getCountryName(res[i]['country'])['chn'] || ""
        })
      }
      this.table = table;
      this.columns=[
        {field:"countryName",title:"地区",order:""},
        {field:"count",title:"数量",order:""},
        {field:"price",title:"价格",order:""},
        {field:"retail_price",title:"最高价",order:""},
      ]
    })
   },
   countrySelect(){
   let country =$("#country").val()
   this.http.request({
     url:"",
     data:{
       "action":"sms/index/select",
       "crud":"getNumbersStatus",
       // "country":country,
       "freePrice":""
     },
       method:"POST"
    }).then((res)=>{
        console.log(res);
      let table=[];
      let keys = Object.keys( res);
      for(let i =0;i<= keys.length -1;i++){
        let code =keys[i].split("_")[0];
        let number= res[keys[i]];
        let name = this.getServerName(code ).name || "" 
        table.push({code:code,number:number,name:name})
      }
      this.table = table;
      this.columns=[
      {field:"name",title:"名称",order:""},
      {field:"code",title:"代码",order:""},
      {field:"number",title:"可用数量",order:""}
    ]
    });
   }
  },
  //生命周期 - 创建完成
  created() {
   
  },
  //生命周期 - 挂载完成
  mounted() {
  },
  //生命周期 - 创建之前
  beforeCreate() { },
  //生命周期- 挂载之前
  beforeMount() { },
  //生命周期 - 更新之前
  beforeUpdate() { },
  //生命周期 - 更新之后
  updated() { },
  //生命周期- 销毁之前
  beforeDestroy() { },
  //生命周期- 销毁完成
  destroyed() { },
  //如果页面有keep-alive 缓存功能，这个函数会触发
  activated() { }
});
JS;
$this->registerJs($js);