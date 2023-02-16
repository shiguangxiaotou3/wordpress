<?php
/** @var $this yii\web\View */



use crud\widgets\PageHeaderWidget;
use crud\assets\AceAsset;
use crud\widgets\CodeEditorWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget(['buttons' =>
        ['<button id="submit" class="page-title-action hide-if-no-customize">保存更改</button>']])
    ?>

    <?= CodeEditorWidget::widget([
        "mode"=>AceAsset::MODE_JSON,
        "options" => [
            "id"=>"editor",
            "style"=>"width: 100%;min-height: 500px;margin-top: 6.5px"
        ],
        'file'=>false
    ]);?>
</div>
<?php
$js =<<<JS
    $("#submit").click(function (){
         var data =   window.JSON.parse(editor.getValue());
        $.post("/wp-json/crud/api/wechat/menu",data.selfmenu_info,function (response){
            if(response.code ==1){
                alert(response.message);
            }else{
               alert(response.message); 
            }
        },"json");  
    });

    $.get("/wp-json/crud/api/wechat/menu",function(response){
        if(response.code ==1){
            editor.insert(JSON.stringify(response.data,null,2));
        }else{
            console.log(response);
            alert(response.message);
        }
    },"json");
JS;
$this->registerJs($js);