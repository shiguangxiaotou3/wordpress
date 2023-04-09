<?php


namespace crud\modules\pay\events;



use yii\base\Event;
use crud\modules\pay\models\Order;
/**
 * Class PayEvent
 *
 * @property string $pal_type 支付场景
 * @property integer|null $user_id 支付场景
 * @property string $order_id 订单id
 * @property string|null $subject 标题
 * @property float $total_amount 订单金额
 * @property float $receipt_amount 实收金额
 * @property string|null $trade_no 支付流水号
 * @property integer|null $notify_number 通知次数
 * @property string|null $notify_url 异步通知url
 * @property string|null $return_url 同步跳转url
 * @property bool $status 支付状态
 * @package crud\modules\pay\events
 */
class PayEvent extends Event
{

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

    /**
     * 创建订单事件处理器
     * 创建订单时，将订单信息保存到数据库
     */
    public function submitEvent(){
        $model = new Order();
        $data = $this->data;
        //$palType , $orderId, $subject, $money, $notifyUrl='', $returnUrl='',
        $model->pal_type = $this->pal_type;
        $model->order_id=$this->order_id;
        $model->subject = $this->subject;
        $model->total_amount = $this->total_amount;
        $model->notify_url = $this->notify_url;
        $model->return_url = $this->return_url;
        $model->save();
    }

    /**
     * 异步通知事件处理器
     * 异步通知 确认后更新订单状态和金额
     */
    public function notifyEvent(){
        $model = Order::find()->where(['order_id'=>$this->order_id])->one();
        if($model  ){
            if($model->status ==0){
                $model->receipt_amount = $this->receipt_amount;
                $model->status = 1;
                $model->trade_no =$this->trade_no;
            }
            if(empty($model->notify_number)){
                $model->notify_number =1;
            }else{
                $model->notify_number ++;
            }
            if($model->save()){
//                wp_mail('757402123@qq.com','更新成功',print_r([$model->getErrors()],true));
            }else{
//                wp_mail('757402123@qq.com','更新失败',print_r([$model->getErrors()],true));
            }

        }
    }

    /**
     * 同步跳转事件处理器
     */
    public function returnEvent(){

    }

    /**
     * 确认支付后更新用户余额的事件处理器
     */
    public function updateUserMoney(){

    }
}