<?php
namespace crud\modules\pay\components;

use yii\base\Component;
class Palpay extends Component implements Pay
{

    public function submit($palType, $orderId, $subject, $money, $notifyUrl = '', $returnUrl = '', $options = [])
    {
        // TODO: Implement submit() method.
    }

    public function select($orderId, $number, $options = [])
    {
        // TODO: Implement select() method.
    }

    public function close($orderId, $number, $options = [])
    {
        // TODO: Implement close() method.
    }

    public function refund($orderId, $number, $money, $refund_reason = '', $out_request_no, $options = [])
    {
        // TODO: Implement refund() method.
    }

    public function refundSelect($orderId, $number, $refund_reason, $options = [])
    {
        // TODO: Implement refundSelect() method.
    }

    public function notify()
    {
        // TODO: Implement notify() method.
    }

    public function test()
    {
        // TODO: Implement test() method.
    }

    public function remit($orderId, $orderMoney, $toUser, $toUserName, $orderTitle = "", $orderRemark = "", $identity_type = 'ALIPAY_LOGON_ID', $options = [])
    {
        // TODO: Implement remit() method.
    }
}