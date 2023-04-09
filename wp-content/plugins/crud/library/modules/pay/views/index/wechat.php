<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use Yii;
use crud\Base;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div style="width: 50%">
        <form action="options.php" method="post">
            <?php
            settings_fields("crud_group_wechatpay");
            do_settings_sections("pay/index/wechat");
            submit_button();
            ?>
        </form>
    </div>
</div>

<?php
$js=<<<JS
$("#platformCertificateFilePath").on('click',function(){
    console.log('z')
    $.ajax({
        url:ajaxurl,
        data:{action:"pay/index/wechat"},
         dataType: 'json',
        type: 'GET',
        success: (res) => {
           if(res.code ==1){
               $('#crud_group_wechatpay_platformCertificateFilePath').attr('value',res.data)
           }else {
               alert(res.message);
           }
        },
      error: (res) => {
        console.log(res);
      }
    });
});
JS;
$this->registerJs($js);
