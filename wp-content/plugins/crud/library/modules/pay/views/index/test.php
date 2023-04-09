<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use crud\Base;
use crud\modules\pay\models\Order;
use yii\helpers\Html;
use crud\widgets\PreCodeWidget;
use crud\widgets\PageHeaderWidget;
use crud\modules\pay\components\Alipay;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div >
        <?php
        $alipay = Yii::$app->alipay;
        $wechatpay =Yii::$app->wechatPay;
//        var_dump($wechatpay->merchantId);

//        dump( $wechatpay->certificates());
//        dump( get_option('crud_group_wechatpay_platformCertificateFilePath'));
//        $wechatpay->update();
//        dump($alipay->payEvent);
//        dump($alipay->hasEventHandlers('notify'));
//        $a =$alipay->client();//
//        echo  $alipay ->signType;
//        dump($model = ->pal_type);
//        $alipay->payEvent->receipt_amount = '0.01';
//        $alipay->payEvent->order_id = 'test_757402123_1679429652';
//        $alipay->payEvent->trade_no = '2023031822001417271411837946';
//        $alipay->trigger('notify');
//       dump($wechatpay->submit("pc","test_757402123_".time(),"test","0.01",'https://www.shiguangxiaotou.com/wp-json/crud/api/pay/index/notify', ''));
//        $url =  $alipay->submit("aliPayWap",
//            "test_757402123_".time(),
//            "test","0.01",
//            'https://www.shiguangxiaotou.com/wp-json/crud/api/pay/index/notify',
//            '');
//        $url =str_replace('\\',"",$url);
//        logObject($url);
//       echo Html::decode($url);
//        wp_mail('757402123@qq.com','表单数据',print_r( $url,true));
        echo $url;
      echo Html::a('ASD',$url);
//        die();

        ?>

    </div>
</div>
