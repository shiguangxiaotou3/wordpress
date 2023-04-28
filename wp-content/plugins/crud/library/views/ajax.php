<?php
/** @var $this yii\web\View */
/** @var $title string */
/** @var $activeUrl string */
/** @var $tableName string */
/** @var $links array */
/** @var $url_prefix string */

use crud\assets\EchartAsset;
use crud\assets\VueAsset;
use crud\assets\SheetJSAsset;

VueAsset::register($this);
SheetJSAsset::register($this);
EchartAsset::register($this);

wp_enqueue_media();

$js =VueAsset::loadComponents();
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
Vue.prototype.$ = jQuery;
Vue.config.productionTip = false;
Vue.component("downloadExcel", JsonExcel)
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
               "init_url" : "{$url_prefix}/{$url}/init",
                // 列表数据url
                "index_url" : "{$url_prefix}/{$url}/index",
                // 新增数据url
                "add_url" : "{$url_prefix}/{$url}/create",
                // 查看数据url
                "view_url" : "{$url_prefix}/{$url}/view",
                // 更新数据url
                "update_url" : "{$url_prefix}/{$url}/update",
                // 删除数据url
                "delete_url": "{$url_prefix}/{$url}/delete",
                "deletes_url" : "{$url_prefix}/{$url}/deletes"
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
$js = str_replace('\'{{LINKS}}\'' ,$links,$js);
$this->registerJs($js);
?>
