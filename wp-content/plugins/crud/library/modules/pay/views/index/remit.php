<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use crud\Base;
use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row">转账业务的标题</th>
            <td>
                <input type="text" id="orderTitle" class="regular-text code" name="orderTitle" value="测试">
                <p>转账业务的标题，用于在支付宝用户的账单里显示。</p>
            </td>
        </tr>
        <tr>
            <th scope="row">收款用户Id</th>
            <td>
                <input type="text" id="toUser" class="regular-text code" name="toUser" value="wanlong757402@outlook.com">
                <p>填写支付宝登录号。示例值：186xxxxxxxx</p>
            </td>
        </tr>
        <tr>
            <th scope="row">收款用户名</th>
            <td>
                <input type="text" id="toUserName" class="regular-text code" name="toUserName" value="万龙">
                <p>参与方真实姓名。如果非空，将校验收款支付宝账号姓名一致性</p>
            </td>
        </tr>
        <tr>
            <th scope="row">金额</th>
            <td>
                <input type="text" id="orderMoney" class="regular-text code" name="orderMoney" value="0.1">
            </td>
        </tr>
        <tr>
            <th scope="row">备注</th>
            <td>
                <input type="text" id="orderRemark" class="regular-text code" name="orderRemark" value="">
            </td>
        </tr>
        </tbody>
    </table>
    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="保存更改"></p>
</div>
<?php
$js =<<<JS

    let orderTitle ='';
    let orderMoney='';
    let toUser="";
    let toUserName="";
    let orderRemark='';
    $('#submit').on("click",function(){
      let orderTitle =$("#orderTitle").val();
      let orderMoney=$("#orderMoney").val();
      let toUser=$("#toUser").val();
      let toUserName=$("#toUserName").val();
      let orderRemark=$("#orderRemark").val();
      $.ajax({
         url:ajaxurl,
         type:'POST',
         data:{ 
           action:"pay/index/remit",
           orderTitle:orderTitle,
           orderMoney:orderMoney,
           toUser:toUser,
           toUserName:toUserName,
           orderRemark:orderRemark
           },
         dataType:'json',
         success:function(res){
          if(res.code ==1){
            alert(res.message)
          }else {
              alert(res.message)
          }
         },
         error:function(res){
             alert('失败');
             console.log(res)
         }
      })
    });
JS;
$this->registerJs($js);
