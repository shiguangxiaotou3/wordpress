<?php
/** @var $this yii\web\View */

use crud\widgets\ControllerActionsWidget;
use crud\assets\AceAsset;
use crud\widgets\PreCodeWidget;
use  crud\widgets\CodeEditorWidget;
?>


    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?=  get_admin_page_parent() ?>
            <small><?php echo esc_html( get_admin_page_title() ); ?></small>
        </h1>
        <hr class="wp-header-end" />
        <?= ControllerActionsWidget::widget(); ?>
        <?php settings_errors(); ?>
        <form class="search-form search-plugins" method="get">
            <p class="search-box">
                <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
                <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
                <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
            </p>
        </form>
        <hr style="width: 100%; " />
        <button id="submit" class="button button-primary">保存更改</button>
        <?= CodeEditorWidget::widget([
            "mode"=>AceAsset::MODE_JAVASCRIPT,
            "options" => [
                "id"=>"editor",
                "style"=>"width: 100%;min-height: 500px;margin-top: 6.5px"
            ]
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
            editor.insert(JSON.stringify(  response.data,null,2));
        }else{
            alert(response.message);
        }
    },"json");
JS;
//$this->registerJs($js);