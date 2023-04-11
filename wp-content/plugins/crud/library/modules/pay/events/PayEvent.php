<?php


namespace crud\modules\pay\events;


use crud\models\wp\WpUsers;
use Yii;
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
 * @property-read  Order $model 错误信息
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


    private $_transaction;
    private $_model;
    private $_error=[];

    /**
     * 创建订单事件处理器
     * 创建订单时，将订单信息保存到数据库
     */
    public function beforeSubmitEvent(){
        $this->_transaction = Yii::$app->db->beginTransaction();
        $model = new Order();
        $model->user_id= $this->user_id;
        $model->pal_type = $this->pal_type;
        $model->order_id=$this->order_id;
        $model->subject = $this->subject;
        $model->total_amount = $this->total_amount;
        $model->notify_url = $this->notify_url;
        $model->return_url = $this->return_url;
        $this->_model = $model;
    }

    public function afterSubmitEvent(){
        $this->model->save();
        $this->_transaction->commit();
    }

    /**
     * 异步通知事件处理器
     * 异步通知 确认后更新订单状态和金额
     */
    public function beforeNotifyEvent(){
        /** @var Order $model */
        $model = Order::find()->where(['order_id'=>$this->order_id])->one();
        if($model){
            if($model->status ==0 and $this->status ==1){
                $model->receipt_amount = $this->receipt_amount;
                $model->status = $this->status;
                $model->trade_no = $this->trade_no;
                $transaction = Yii::$app->db->beginTransaction();
                $u = new WpUsers();
                $user = $u->getUserById($model->user_id);
                $res = $user->updateUserMoney(
                    $model->receipt_amount,
                    $model->subject
                );
                if ($res and $model->save()) {
                    $transaction->commit();
                } else {
                    $transaction->rollBack();
                }

            }else{
                if(empty($model->notify_number)){
                    $model->notify_number =1;
                }else{
                    $model->notify_number ++;
                }
                $model->save();
            }
            $this->_model = $model;
        }
    }


    public function afterNotifyEvent(){
        $user= new WpUsers();
        $user->getUserById($this->model->user_id);
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


    public function getModel(){
        return $this->_model;
    }
}