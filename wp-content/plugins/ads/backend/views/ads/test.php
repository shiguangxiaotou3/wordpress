<?php
/** @var $this yii\web\View */
/** @var $myText  */

use yii\web\View;

use yii\helpers\Html;
use yii\helpers\Markdown;
use crud\assets\HighlightAsset;
use crud\widgets\ControllerActionsWidget;
use crud\widgets\WpTableWidget;

?>


    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?>
            <small> 文档</small>
        </h1>
        <hr class="wp-header-end" />
        <?php settings_errors(); ?>
        <?= ControllerActionsWidget::widget(); ?>
        <form class="search-form search-plugins" method="get">
            <p class="search-box">
                <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
                <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
                <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
            </p>
        </form>
        <hr style="width: 100%;" />
        <h2>广告组</h2>
        <input type="text" id="crud_group_ads_campaignId"
               class="regular-text code" value="<?=get_option("crud_group_ads_campaignId","482026743");?>"/>
        <?=  Html::a("查询","#",["class"=>"button button-success","id"=>"campaign"]) ?>
        <div id="campaign_html"></div>
        <hr style="width: 100%;" />
        <h2>关键词</h2>
        <div id="keyword_html"></div>
        <?php

//        json_decode( json_encode(Yii::$app->ads->GetKeywordsByAdGroupId()),true);

//        $code = json_decode( json_encode(Yii::$app->ads->GetKeywordsByAdGroupId("1229254305018244")),true);
//        if (isset($code['Keywords']['Keyword'])) {
//            echo WpTableWidget::widget([
//                "columns" => [
//                    ['field' => 'Id', 'title' => 'Id'],
//                    ['field' => 'MatchType', 'title' => 'MatchType'],
//                    ['field' => 'Text', 'title' => 'Text'],
//                    ['field' => 'Status', 'title' => 'Status'],
//                ], 'data' => $code['Keywords']['Keyword']
//            ]);
//        }
        ?>
    </div>
<?php

$js=<<<JS
 $("#campaign").click(function (){
     var campaign_id = $("#crud_group_ads_campaignId").val();
    $.get("/wp-json/ads/api/getAdGroups?campaignId="+campaign_id, "",function (response) {
        if(response.code ==1){
            $("#campaign_html").append(response.data);
        }else{
            alert("查询失败")
        }
        },"json"
    )   
});
$("body").on('click','.adGroupId',function(){
    var adGroupId =$(this).attr("data-adGroupId");
    $.get("/wp-json/ads/api/getkeyword?adGroupId="+adGroupId, "",function (response) {
        if(response.code ==1){
            $("#keyword_html").append(response.data);
        }else{
            alert("查询失败")
        }
        },"json"
    )
});
$("body").on('click','.keyword',function(){
    var adGroupId =$(this).attr("data-adGroupId");
    var Id =$(this).attr("data-Id");
    var Status =$(this).attr("data-Status");
    console.log( adGroupId,Id,Status);
    $.get("/wp-json/ads/api/updateKeyword?adGroupId="+adGroupId+"&Id="+Id+"&Status="+Status, "",function (response) {
        console.log(response);
        if(response.code ==1){
              alert(response.message)
        }else{
            alert(response.message)
        }
        },"json"
    )
});
JS;
$this->registerJs($js);
$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle){
    $this->registerAssetFiles($name);
}