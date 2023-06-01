<?php
/** @var $this yii\web\View */
/** @var $model crud\modules\pay\models\Order */
/** @var $url string */
/** @var $file array */
/** @var $code  */

use crud\widgets\PageHeaderWidget;
use crud\assets\VueAsset;

    wp_enqueue_media();
    VueAsset::register($this);
    if(is_array($file)){
        $data =json_encode($file);
    }else{
        $data =json_encode([]);
    }

?>
<div class="wrap">
    <?= PageHeaderWidget::widget([
        'buttons'=>[
            '<input type="button" class="page-title-action  thickbox" value="添加" @click="swiperUpload" />',
            '<input type="button" class="page-title-action  thickbox" value="提交" @click="submit" />',
        ]
    ]) ?>
    <div  class="notice-success notice">
        <p><strong>温馨提示</strong></p>
        <p>更改或删除文件映射之后,需要刷新固定链接,请前往<a href="/wp-admin/options-permalink.php">固定路由</a>刷新路由</p>
    </div>
    <table class="wp-list-table widefat fixed striped table-view-list" style="margin-top: 20px">
        <thead>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <td id="domainName" class="manage-column" style="width: 200px"><span>文件名</span></td>
            <td id="createTime" class="manage-column" ><span>路径</span></td>
            <td id="recordCount" class="manage-column" style="width: 200px"><span>上传时间</span></td>
            <td id="remark" class="manage-column" style="width: 100px"><span>操作</span></td>
        </tr>
        </thead>
        <tbody id="the-list">
            <tr v-for="(item,index) in files"  :id="'post-'+(index +1)">
                <th scope="row" class="check-column">
                    <label class="screen-reader-text" for="cb-select-1">选择</label>
                    <input id="cb-select-1" type="checkbox" name="post[]" :value="item.id">
                    <div class="locked-indicator">
                        <span class="locked-indicator-icon" aria-hidden="true"></span>
                    </div>
                </th>
                <td class="domainName column-fileName" data-colname="名称">{{item.filename}}</td>
                <td class="createTime column-filePath" data-colname="路径">{{item.url}}</td>
                <td class="remark column-remark" data-colname="上传时间">{{item.dateFormatted}}</td>
                <td class="remark column-remark" data-colname="操作">
                    <div class="button-group">
                        <div class="button" style="padding: 0px 4px; line-height: 28px;" @click=" deleteItem(index)">
                            <span class="dashicons dashicons-no" style="margin: 4px 0px;"></span>
                        </div>

                    </div>
                </td>
            </tr>

        </tbody>
        <tfoot>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">全选</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <td id="domainName" class="manage-column" ><span>文件名</span></td>
            <td id="createTime" class="manage-column" ><span>路径</span></td>
            <td id="recordCount" class="manage-column"><span>上传时间</span></td>
            <td id="remark" class="manage-column"><span>操作</span></td>
        </tr>
        </tfoot>
    </table>
</div>
<?php
$js=<<<JS
new Vue({
    el: '.wrap',
    data(){
        return {
            files:{$data},
        }
    },
     methods:{
        swiperUpload(e){
            e.preventDefault();
            let image = wp.media({
                title: '请选择媒体',
                // library: {type: 'image'},
                button: {text: '选择'},
                multiple: true
            })
            .open()
            .on('select',()=>{
                let images = image.state().get('selection').toArray();
                for(let i =0;i<=(images.length -1);i++){
                    let img_item =(images[i]).toJSON();
                    img_item.url =this.url(img_item.url);
                    console.log(img_item)
                    this.files.push(img_item)
                }
            }).on('close',()=>{
                let images = image.state().get('selection').toArray();
            });
        },
        submit(){
            $.ajax({
                url:ajaxurl+"?action=base/index/mapping",
                type:'POST',
                data:{files:this.files},
                dataType:'json',
                success:(res)=>{
                    if(res.code ==1){
                        alert('提交成功')
                    }else{
                         alert('提交失败')
                    }
                    
                },
                error:(res)=>{
                    console.log(res)
                }
            });
        },
        url(url){
            const hostname = window.location.hostname;
            return url.replace(new RegExp(`^https?:\/\/\${hostname}`), '');
        },
        deleteItem(index){
          this.files.splice(index,1);  
        },
     },
     mounted() {
  }
});
JS;
$this->registerJs($js);
