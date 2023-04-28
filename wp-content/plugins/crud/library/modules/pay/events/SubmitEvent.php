<?php


namespace crud\modules\pay\events;


use crud\modules\pay\models\Order;
use yii\base\Event;

class SubmitEvent extends Event
{

    public $data;
    public $pal_type; //支付场景
    public $user_id; //支付场景
    public $order_id; //订单id
    public $subject; //标题
    public $total_amount; //订单金额
    public $receipt_amount; //实收金额
    public $trade_no; //支付流水号
    public $notify_number; //通知次数
    public $notify_url; //异步通知url
    public $return_url; //同步跳转url
    public $status; //支付状态

    public function submitEvent(){
//        $model = new Order();
//        $data = $this->data;
//        //$palType , $orderId, $subject, $money, $notifyUrl='', $returnUrl='',
//        $model->pal_type = $data['palType'];
//        $model->order_id= $data['orderId'];
//        $model->subject = $data['palType'];
//        $model->pal_type = $data['palType'];
    }


    public function notifyEvent(){

    }

    public function returnEvent(){

    }



    public function updateUserMoney(){

    }
}