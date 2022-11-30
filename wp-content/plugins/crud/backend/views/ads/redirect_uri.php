<?php
/** @var $this yii\web\View */
use crud\widgets\ControllerActionsWidget;
use crud\widgets\PreCodeWidget;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?=  get_admin_page_parent() ?>
        <small> <button class="button button-success" id="test"> 测试</button></small>
    </h1>
    <hr class="wp-header-end" />
    <?= PreCodeWidget::widget([
        'language' => "json",
        "code" => "",
        "options" => ['id'=>"results","style"=>"display:none"]]);
    ?>
    <?php settings_errors(); ?>
    <?= ControllerActionsWidget::widget(); ?>
    <form class="search-form search-plugins" method="get">
        <p class="search-box" style="display: ">
            <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
            <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
        </p>
    </form>
    <hr style="width: 100%;" />
    <div style="width: 50%">
        <form action="options.php" method="post">
            <?php
                settings_fields("crud_group_flows");
                do_settings_sections("ads/redirectUri");
                submit_button();
            ?>
        </form>
    </div>

</div>
<?php
$action = Yii::$app->controller->id."/".Yii::$app->controller->action->id;
$nonce = wp_create_nonce( 'post_like_nonce' );
$csrf = Yii::$app->request->getCsrfToken();
$time =time();
$js=<<<JS
 $("#test").click(function (){
     var stream_id = $("#crud_group_flows_stream_id").val();
     var name = $("#crud_group_flows_name").val();
     var mode = $("#crud_group_flows_mode").val();
     var payload = $("#crud_group_flows_payload").val();
    if( stream_id == "" || name == ""   || mode =="" || payload ==""){
        alert("参数提交不完整");
    }else {
          let tmp_data ={
            nonce:"{$nonce}",
            action: "{$action}",
            num: "{$time}",
            _csrf: "{$csrf}",
            data: {stream_id:stream_id,name:name, mode: mode,payload:payload.split('\\n')}
          };
          $.post(ajaxurl, tmp_data, 
            function (response) {
                $("#results").show();
                 $("#results code").html(JSON.stringify(  response.data,null,2));
                hljs.highlightBlock(document.querySelectorAll("#results>code")[0]);
            },
            "json"
        )   
    }
});
JS;
$this->registerJs($js);
