<?php
/** @var $this yii\web\View */

use yii\web\View;
use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_market");
        do_settings_sections("market/index/settings");
        submit_button();
        ?>
    </form>
    <button class="btn-primary" id="custom-upload" >asd</button>
</div>
<?php
$js=<<<JS
jQuery(document).ready(function() {
    var ashu_upload_frame;
    var value_id;
    jQuery('#custom-upload').on('click',function(event){
    value_id =jQuery( this ).attr('id');
    event.preventDefault();
    if( ashu_upload_frame ){
      ashu_upload_frame.open();
      return;
    }
    ashu_upload_frame = wp.media({
      title: '选择或上传图片', // 窗口标题
      button: {
        text: '选择', // 选择按钮文字
      },
      multiple: false // 是否允许多选
    });
    
    });
});
JS;
$this->registerJs($js, View::POS_END);