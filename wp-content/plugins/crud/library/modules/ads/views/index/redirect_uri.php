<?php
/** @var $this yii\web\View */

use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;

?>
<div class="wrap">
    <?= PageHeaderWidget::widget([
        'buttons' => [Html::button('测试',['id'=>'test',"class"=>"button button-success"])]
    ]) ?>
    <?= PreCodeWidget::widget([
        'language' => "json",
        "code" => "",
        "options" => ['id'=>"results","style"=>"display:none"]]);
    ?>
    <div style="width: 50%">
        <form action="options.php" method="post">
            <?php
                settings_fields("crud_group_flows");
                do_settings_sections("ads/index/redirectUri");
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
