<?php
/** @var $this yii\web\View */
/** @var $url string */
/** @var $token  */
/** @var $code  */

use crud\models\wp\WpUsers;
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
//        $alipay = Yii::$app->alipay;
//        $wechatpay =Yii::$app->wechatPay;
//        $notifyUrl = 'https://www.shiguangxiaotou.com/wp-json/crud/api/pay/index/notify';
//        $returnUrl ='https://www.shiguangxiaotou.com/crud/index/pay';
//        $options = [];
////        try{
//            $res =   $alipay->submit(
//                'aliPayPc',1,"text_".time(),
//                "测试","0.01",$notifyUrl,$returnUrl,[]
//            );
//            echo $res;
//        echo $wechatpay->getWechatPayNo();
//        dump(['notifyUrl'=>$alipay->notifyUrl,'returnUrl'=>$alipay->returnUrl]);
//        dump(['notifyUrl'=>$wechatpay->notifyUrl,'returnUrl'=>$wechatpay->returnUrl]);
////        }catch (Exception $exception){
////            var_dump($exception);
////        }
//
////          var_dump($res);
        ///
        ///

//            $event =new \crud\modules\pay\events\PayEvent();
//            $event->order_id = 'text_1681137069';
//            $event->status =1;
//            $event->receipt_amount ="0.01";
//            $event->trade_no ="asdas";
//            $event->beforeNotifyEvent();

           $user = Order::find()->where(['id'=>25])->one();;
           /** @var yii\db\ActiveQuery $query */
           $query = $user->getUser();
           dump( $query ->asArray()->one());


//        $model = Order::find()->where(['order_id'=>'text_1681137069'])->one();
//        if($model){
//            echo "true".PHP_EOL;
//            if($model->status ==0 and $this->status ==1){
//                $model->receipt_amount = $this->receipt_amount;
//                $model->status = $this->status;
//                $model->trade_no = $this->trade_no;
//                $transaction = Yii::$app->db->beginTransaction();
//                $u = new WpUsers();
//                $user = $u->getUserById($model->user_id);
//                $res = $user->updateUserMoney(
//                    $model->receipt_amount,
//                    $model->subject
//                );
//                if ($res and $model->save()) {
//                    wp_mail('757402123@qq.com','成功','');
//                    $transaction->commit();
//                } else {
//                    wp_mail('757402123@qq.com','回滚','');
//                    $transaction->rollBack();
//                }
//
//            }else{
//                wp_mail('757402123@qq.com','不是第一次','');
//                if(empty($model->notify_number)){
//                    $model->notify_number =1;
//                }else{
//                    $model->notify_number ++;
//                }
//                $model->save();
//            }
//            $this->_model = $model;
//        }else{
//            wp_mail('757402123@qq.com','订单不存在','');
//        }

        ?>

    </div>
</div>
