<?php


namespace crud\modules\pay\components;


/**
 * Interface Pay
 * @package crud\modules\pay\components
 * @property-read  crud\modules\pay\events\PayEvent $payEvent
 */
interface Pay
{

    /**
     * 创建订单
     * @param 订单场景 $palType
     * @param 用户id|int|null $userId
     * @param 订单号|string $orderId
     * @param 订单标题|string $subject
     * @param 订单金额|number $money
     * @param 异步通知url string $notifyUrl
     * @param 支付完成跳转url string $returnUrl
     * @param array $options
     * @return mixed
     */
    public function submit($palType,$userId,$orderId,$subject,$money,$notifyUrl='',$returnUrl='',$options=[]);

    /**
     * 订单查询
     * 商家订单号,支付宝流水号不能同时为空
     * @param string $orderId 商家订单号
     * @param string $number 支付宝交易流水号
     * @param $options
     * @return mixed
     */
    public function select($orderId,$number,$options=[]);

    /**
     * 订单关闭
     * 商家订单号,支付宝流水号不能同时为空
     * @param $orderId
     * @param $number
     * @param array $options
     * @return false|mixed
     * @throws Exception
     */
    public function close($orderId,$number,$options=[]);

    /**
     * 订单退款
     * 商家订单号,支付宝流水号不能同时为空
     *
     * @param 商家订单号 $orderId
     * @param 支付宝流水号 $number
     * @param 退款金额 $money
     * @param 退款原因|string $refund_reason
     * @param 退款请求号|string|null $out_request_no
     * @param array $options
     * @return mixed
     */
    public function refund($orderId,$number,$money,$refund_reason ='',$out_request_no,$options=[]);

    /**
     * @param 商家订单号 $orderId
     * @param 支付宝流水号 $number
     * @param 退款请求号|string $refund_reason
     * @param array $options
     * @return false
     * @throws Exception
     */
    public function refundSelect($orderId,$number,$refund_reason,$options=[]);

    /**
     * 异步通知
     * @param array $data
     * @return mixed
     */
    public function notify($data);

    /**
     * 转账到支付宝账户 仅在证书模式下有效
     * @param $orderId 转账id 商家自定义保证唯一性
     * @param $orderMoney 转账金额
     * @param $toUser 收款方唯一标识
     * @param $toUserName 收款方名称
     * @param string $orderTitle 转账标题
     * @param string $orderRemark 转账备注信息
     * @param string $identity_type
     * @param array $options 其他参数
     * @throws Exception
     */
    public function remit($orderId,$orderMoney,$toUser,$toUserName, $orderTitle="",$orderRemark="", $identity_type='ALIPAY_LOGON_ID',$options=[]);
}