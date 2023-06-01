
Vue.component("crud-table", {
  template: `
<div>
    <!-- nav -->
    <crud-tablenav-pages 
     :page="page" 
     :total="total" 
     :pageSize="pageSize" 
     @sizeChange="pageSizeChange"
     @pageChange="pageChange">
        <template v-slot:buttons>
            <div  class="alignleft actions bulkactions">
                <input type="submit" class="button action" value="新增" @click="add">
            </div>
            <div class="alignleft actions">
                <input type="submit" class="button action" value="批量删除" @click="deletes">
                <input type="submit" class="button action" value="刷新" @click="refresh">
            </div>
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label>
                <select name="action"  placeholder="隐藏字段" >
                    <option v-for="(item,index) in columns" :value="item.field" v-html="item.title" />
                </select>
                <input type="submit" id="doaction" class="button action" value="应用">
            </div>
            <div class="alignleft actions bulkactions">
                <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label>
                <select name="action"  placeholder="隐藏字段" ref="exportType" >
                    <option  value="Excel" v-html="'Excel'" />
                    <option  value="text" v-html="'Text'" />
                </select>
                <input type="submit"  class="button action" value="导出" @click="exportFile">
                    <download-excel 
                     :data="table"
                     :fields="json_fields"
                     :worksheet="tableName"
                     :name="tableName + '.xls'"
                     style="display: none"
                    ><a ref="downloadExcel">Excel</a></download-excel>
            </div>
        </template>
    </crud-tablenav-pages>
    <!-- end nav -->
    
    <!-- table -->
    <div style="width: 100%;overflow-x: scroll;">
        <table style="table-layout: auto;width: 100%;overflow-x: auto;" class="wp-list-table widefat striped fixed  table-view-list" >
            <!-- thead -->
            <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                        <input id="cb-select-all-1" type="checkbox" @click="selectorAll">
                    </td>
                    <crud-columns-thead v-for="(field,index) in columns" :key="index" :field="field" />
                    <th id="actions" v-if="operate.length>0" class="manage-column" style="width: 130px">操作</th>
                </tr>
            </thead>
            <!-- end thead -->
            
            <!-- tbody -->
            <tbody id="the-list">
                <!-- 有数据 -->
                <template v-if="(table.length >0)">
                    <tr  v-for="(row,indexTr) in table" :id="'post'+indexTr">
                        <!-- first -->
                        <th scope="row" class="check-column">
                            <label class="screen-reader-text" for="cb-select-1">选择</label>
                            <input 
                             type="checkbox" 
                             name="post[]"
                             :id="'cb-select-'+indexTr"   
                             :value="indexTr" 
                             @click="checkbox(row.id)" />
                            <div class="locked-indicator">
                                <span class="locked-indicator-icon" aria-hidden="true"></span>
                            </div>
                        </th>
                        <!-- end first -->  
                        
                        <!-- content first --> 
                        <crud-columns-tbody 
                         v-for="(field,column_index) in columns" 
                         :key="column_index"   
                         :field="field" 
                         :row="row"
                         @showMiniModal="showMiniModal" 
                         @closeMiniModal="closeMiniModal"/>
                        <!-- end content --> 
                        
                        <!-- last -->
                        <td v-if="operate.length>0">
                            <div class="button-group" >
                                <template v-for="(button,butIndex) in operate">
                                    <div style="padding:0 4px;line-height: 28px"
                                     :class="button.class + ((butIndex ==0) ? ' last-child' : ((butIndex ==(operate.length)-1))?' first-child':'')" 
                                     @click="buttonsClick(button.name,indexTr,(button.callBack || ''))">
                                        <span v-if="button.icons" :class="button.icons" style="margin: 4px 0"></span>
                                        {{button.text}}
                                    </div>
                                </template>
                            </div>
                        </td>
                        <!-- end last -->
                    </tr>
                </template>
                <!-- 没有数据 -->
                <template v-else>
                     <tr >
                        <td :colspan="columns.length +((operate.length>0)?2:1)" style="color: red">Nothing</td>
                    </tr>
                </template>
            </tbody>
            <!-- end tbody -->
            
            <!-- tfoot -->
            <tfoot>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                        <input id="cb-select-all-1" type="checkbox" @click="selectorAll">
                    </td>
                    <crud-columns-thead v-for="(field,index) in columns" :key="index" :field="field" />
                    <th id="actions" v-if="operate.length>0" class="manage-column" style="width: 130px">操作</th>
                </tr>
            </tfoot>
            <!-- end tfoot -->
      </table>
    </div>
    <!-- end table -->
    
    <!-- modal -->
    <crud-modal-container 
     :rowId="rowId" 
     :active="modal" 
     :title="title" 
     :actionType="actionType"
     @next="next" 
     @previous="previous" 
     @close="close"  
     @submit="submit" 
     @update="update" 
     @delete="deleteAll">
        <template v-slot:left>
            <crud-from 
            test="asda"
             :tableName="tableName" 
             :submitUrl="submitUrl" 
             :columns="columns" 
             :actionType="actionType" 
             :row="row" />
        </template>
        <template v-slot:right>
           <h1>right</h1>
        </template>
    </crud-modal-container>
    <!-- end modal -->
    
    <!-- modal mini -->
    <crud-modal-mini :active="showMini">
        <!-- header -->
        <template v-slot:theme-header>
            <button class="left dashicons dashicons-no"><span class="screen-reader-text"></span></button>
            <button class="right dashicons dashicons-no disabled" ><span class="screen-reader-text"></span></button>
            <button class="close dashicons dashicons-no" @click="closeMiniModal"><span class="screen-reader-text"></span></button>
        </template>
        <!-- end header -->
        
        <!-- screenshots  -->
        <template v-slot:theme-screenshots>
            <div class="theme-screenshots">
                <div class="screenshot"  ></div>
            </div>
        </template>
        <!-- end screenshots -->
        
        <!-- info  -->
        <template v-slot:theme-info>
            <div class="theme-info">
              <h2 class="theme-name"><span class="theme-version"></span></h2>
              <p class="theme-author"></p>
              <p class="theme-description"></p>
              <p class="theme-tags"></p>
            </div>
        </template>
        <!-- end info -->
        
        <!-- right  -->
        <template v-slot:actions-right></template>
        <!-- end right -->
        
        <!-- content  -->
        <template v-slot:actions-content>
             <input type="button" class="button activate" @click="closeMiniModal" value="关闭" />
        </template>
        <!-- end content-->
        
        <!-- right  -->
        <template v-slot:actions-right>
            <a href="" class="button delete-theme" >删除</a>
        </template>
        <!-- end right -->
        
    </crud-modal-mini>
    
    

    <!-- end modal mini-->
</div>`,
  data() {
    return {
      n:0,
      ids:[],
      tableName:this.defaultTableName,
      // 控制窗体显示隐藏
      modal:false,
      // 当前页数
      page: this.defaultPage,
      // 总记录数
      total: 0,
      // 分页大小
      pageSize: this.defaultPageSize,
      // 表格数据
      table: [],
      // 表格列配置
      columns: [],
      // 操作数据的url
      actionType:'add',
      title:this.tableName,
      showMini:false,
      miniContent:'',
      miniInfo:'',
      operate:[],
      defaultOperate:[
        {
          'name': 'view',
          'class': 'button ',
          'icons': 'dashicons dashicons-visibility',
        },
        {
        'name': 'edit',
          'class': 'button ',
          'icons': 'dashicons dashicons-welcome-write-blog',
        },
        {
          'name': 'delete',
          'class': 'button button-small button-link-delete',
          'icons': 'dashicons dashicons-no',
        },
      ]
    }
  },
  watch: {
    page(page){
      if(page >= 1 && page<=this.pageSum){
        this.index(page)
      }
    }
  },
  props: {
    defaultTableName:{
        type:String,
        require:true,
      },
    defaultPage:{
        type:Number,
        require:true,
        default: 1
      },
    defaultPageSize:{
        type:Number,
        require:true,
      },
    defaultActions:{
        type:Object,
        require:true
      }
  },
  computed: {
    row(){
      let index = this.n;
      let data = this.table;
      return data[index] ? data[index]:{}
    },
    rowId(){
      return parseInt((this.row)['id']) || 0;
    },
    submitUrl(){
      return ajaxurl;
    },
    actions(){
      return this.defaultActions
    },
    // 定义下载字段
    json_fields(){
        let fields ={};
        for (let i =1;i<= this.columns.length -1;i++){
            let name =(this.columns)[i]['field'];
            let title =(this.columns)[i]['title'];
            if((name =='created_at')||(name =='updated_at')){
                fields[title]={
                    field: name,
                    callback: (value) => {
                        return new Date(value*1000).format("yyyy-MM-dd hh:mm")
                    }
                };
            }else {
                fields[title]=name
            }
        }
        return fields;
    },
  },
  methods: {
    pageChange(value){
      this.index(value)
    },
    fromData(type){
      let data ={};
      data[this.tableName]={};
      let from =this.$("#"+this.tableName).serializeArray()
      this.$.each(from,  (index, item) =>{
        let key = item.name.match(/\[(.+?)\]/g)[0].replace('[', "").replace(']', "");
        data[this.tableName][key] = item.value;
      });
      console.log(data)
      if(type =='submit'){
        data.action =this.actions.add_url;
        delete data[this.tableName]['id']
        delete data[this.tableName]['created_at']
        delete data[this.tableName]['updated_at']
      }else if(type == 'update'){
        data.action =this.actions.update_url;
        data[this.tableName]['id']=this.rowId;
        delete data[this.tableName]['created_at']
        delete data[this.tableName]['updated_at']
      }else if(type == 'delete'){
        data.action =this.actions.delete_url;
        delete data[this.tableName]['created_at']
        delete data[this.tableName]['updated_at']
      }
      return data;
    },
    selectorAll(){
      let ids =[];
      for (let i =0; i<=this.table.length-1;i++){
         ids.push((this.table)[i]['id'])
      }
      this.ids =ids;
    },
    deletes(){
      if(this.ids.length >0){
        this.$.ajax({
          url: ajaxurl,
          type: 'POST',
          data: {
            action: this.actions.deletes_url,
            ids:  this.ids,
          },
          dataType: 'json',
          success: (res) => {
            if (res.code == 1) {
              for (let i =0;i<= this.ids.length -1;i++){
                let index = this.table.findIndex(item => item.id === (this.ids)[i]);
                this.table.splice(index, 1)
              }
              this.noticeSuccess('删除成功')
            }else {
              this.noticeError(res.message)
            }
          },
          error: (res) => {
            console.log(res);
          }
        })
      }else{
        this.noticeError('抱歉你没有选中记录')
      }
    },
    checkbox(id){
      this.ids.push(id)
    },
    error(data){
      for (let key in data){
        let item ={};
        for(let i=0;i<= this.columns.length -1;i++){
          item = (this.columns)[i];
          if(item.field == key ){
            item.error = true;
            item.message =data[key][0]||'error';
            this.columns.splice(i,1,item);
         }
       }
      }
    },
    init(){
      this.$.ajax({
        url: ajaxurl,
        type: 'GET',
        data: {
          action: this.actions.init_url
        },
        dataType: 'json',
        success: (res) => {
          if (res.code == 1) {
            let result = res.data.columns;
            const found = result.find(item => item.field ==='operate');
            if(found){
              for (let i =1;i<= result.length -1;i++){
                if(result[i].field =='operate'){
                  this.operate = result[i].buttons || []
                  result.splice(i,1)
                }
              }
            }else {
              this.operate = this.defaultOperate
            }
            this.columns = result;
          }
        },
        error: (res) => {
          console.log(res);
        }
      })
    },
    index(page){
      this.$.ajax({
        url: ajaxurl,
        type: 'GET',
        data: {
          action: this.actions.index_url,
          page: page||this.page,
          pageSize: this.pageSize
        },
        dataType: 'json',
        success: (res) => {
          if (res.code == 1) {
            // 当前页数
            this.page = parseInt(res.data.page +1);
            // 总记录数
            this.total =parseInt( res.data.total);
            // 分页大小
            this.pageSize = parseInt(res.data.pageSize);
            // 表格数据
            this.table = res.data.table;
          }
        },
        error: (res) => {
          console.log(res);
        }
      })
    },
    open(){
      if(this.modal){
        this.$('body').removeClass('modal-open')
      }else{
        this.$('body').addClass('modal-open')
      }
      this.modal =!this.modal;
    },
    next() {
      if(this.n <= (this.table.length -1)){
        this.n ++;
      }
    },
    previous() {
      if(this.n >0){
        this.n --;
      }
    },
    close(){
     this.modal =!this.modal;
    },
    submit(){
      let fromData =this.fromData('submit');
      this.$.ajax({
        url: ajaxurl,
        type: 'POST',
        data: fromData,
        dataType: 'json',
        success: (res) => {
          console.log(res)
          if (res.code == 1) {
            this.table.push((res.data)[0])
            this.n =  -1
            this.open();
            this.noticeSuccess('创建成功')
          }else {
            this.error(res.data)
          }
        },
        error: (res) => {
          this.noticeError('服务器错误')
        }
      })
    },
    update(){
      let fromData =this.fromData('update');
      if(fromData[this.tableName]['id'] ==undefined){
        this.showMini =true;
        this.miniContent ='id:字段不能为空';
        console.log('意外结束')
        return;
      }
      this.$.ajax({
        url: ajaxurl,
        type: 'POST',
        data: fromData,
        dataType: 'json',
        success: (res) => {
          console.log(res)
          if (res.code == 1) {
            this.table.splice(this.n, 1)
            this.open();
            this.noticeSuccess('修改成功')
          }else {
            this.error(res.data)
          }
        },
        error: (res) => {
        }
      })
    },
    refresh(){
        this.index();
        this.noticeSuccess('刷新成功','')
    },
    deleteAll(){
      let fromData =this.fromData('delete');
      this.$.ajax({
        url: ajaxurl,
        type: 'POST',
        data: fromData,
        dataType: 'json',
        success: (res) => {
          if (res.code == 1) {
            this.columns.splice(this.n,1);
            this.n =-1
            this.open();
            this.noticeSuccess('删除成功')
          }else {
            this.error(res.data||{})
          }
        },
        error: (res) => {
          console.log(res);
        }
      })
    },
    noticeError(title,content){
      let notice ={
        active:true,
        noticeType:'notice-error',
        title:title || 'Error',
        content:content || "",
      }
      this.$emit('message',notice)
    },
    noticeSuccess(title,content){
      let notice ={
        active:true,
        noticeType:'notice-success',
        title:title || 'Success',
        content:content || "",
      }
      this.$emit('message',notice)
    },
    add(){
      this.n =-1
      this.title ='新增记录'
      this.actionType='add'
      this.open();
    },
    view(n){
      this.n =n
      this.title ='查看 #ID:'+(this.row.id ||this.row.ID||'' )
      this.actionType='view'
      this.open();
    },
    edit(n){
      this.n =n
      this.title ='编辑 #ID:'+(this.row.id ||this.row.ID||'' )
      this.actionType='edit'
      this.open();
    },
    test(){
      console.log('ad')
    },
    operateAction(index,url){

    },
    buttonsClick(name,index,callBack){
      if(name =='view'){
        this.view(index)
      }else if(name =='edit'){
        this.edit(index)
      }else if(name =='delete'){
        this. deleteRow(index)
      }else {
        this.n =index
        if(callBack){
          eval('('+callBack+')').call(this,options,this.row,index);
        }
      }
    },
    exportFile(){
        this.$refs.exportType;
        let exportType =this.$refs.exportType.value;
        if(exportType =='Excel'){
            this.$refs.downloadExcel.click()
        }

    },
    deleteRow(n){
        let res=confirm("确定要删除此记录吗?");
        if(res ==true){
            this.n =n
            this.ids=[];
            this.ids.push(this.row.id)
            this.deletes();
        }
    },
    showMiniModal(data){
        this.showMini =true;
    },
    closeMiniModal(data){
      this.showMini =false;

    },
    pageSizeChange(value){
      console.log('table')
      this.pageSize =parseInt(value);
      this.index(this.page)
    }

  },
  //生命周期 - 创建完成
  created() {
    this.init();
    console.log('初始化完成')
  },
  //生命周期 - 挂载完成
  mounted() {
    this.index();
    console.log('首次价值完成')
  },
});