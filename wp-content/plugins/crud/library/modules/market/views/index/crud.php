<?php
/** @var $this yii\web\View */
/** @var $title string */
/** @var $activeUrl string */
/** @var $tableName string */
/** @var $links array */

use crud\Base;
use crud\assets\EchartAsset;
use crud\assets\VueAsset;


VueAsset::register($this);
EchartAsset::register($this);
wp_enqueue_media();
$component =[
        'common.js','modal.js','table.js','tablenav-pages.js',
    'notice.js','columns.js','nav-tab-wrapper.js','crud.js'
];
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
$url = toUnderScore($tableName,'-');
$js .=<<<JS
new Vue({
    el: '.wrap',
    data(){
        return {
            title:'{$title}',
            activeUrl:'{$activeUrl}',
            links:'{{LINKS}}',
            notice:{active:false,noticeType:'notice-success',title:'',content:'',close:true},
            tableName:"{$tableName}",
            page:1,
            pageSize:10,
            actions: {
               "init_url" : "market/{$url}/init",
                // 列表数据url
                "index_url" : "market/{$url}/index",
                // 新增数据url
                "add_url" : "market/{$url}/create",
                // 查看数据url
                "view_url" : "market/{$url}/view",
                // 更新数据url
                "update_url" : "market/{$url}/update",
                // 删除数据url
                "delete_url": "market/{$url}/delete",
                "deletes_url" : "market/{$url}/deletes"
            }
        }
    },
    methods:{
        message(notice){
            this.notice = notice
        }
    },
     mounted(){
        console.log(this.links)
     }
});
JS;
$js = str_replace('\'{{LINKS}}\'' ,$links,$js);
$this->registerJs($js);




?>
