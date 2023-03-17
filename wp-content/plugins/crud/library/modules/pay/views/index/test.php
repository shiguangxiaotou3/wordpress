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
    <div >
        <?php
        $alipay = Yii::$app->alipay;
        $a =$alipay->client();
//        dump($alipay->client()->alipayrsaPublicKey);
//        //读取公钥文件
//        $pubKey = file_get_contents($rsaPublicKeyFilePath);
//        //转换为openssl格式密钥
//        dump($a);
//        $res = openssl_get_publickey($pubKey);
//            dump( get_class( $alipay->client()));
       dump($alipay->submit("pc","test_757402123_".time(),"test","0.1",'https://www.shiguangxiaotou.com/wp-json/crud/api/pay/index/notify', ''));
        ?>
    </div>
</div>
