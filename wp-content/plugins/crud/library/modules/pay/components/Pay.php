<?php


namespace crud\modules\pay\components;


interface Pay
{

    /**
     * 信息报备
     * @return mixed
     */
    public function risk();

    /**
     * 订单创建
     * @return mixed
     */
    public function submit();

    /**
     * 订单查询
     * @return mixed
     */
    public function select();

    /**
     * 订单关闭
     * @return mixed
     */
    public function close();

    /**
     * 订单撤销
     * @return mixed
     */
    public function reverse();

    /**
     * 订单退款
     * @return mixed
     */
    public function refund();

    /**
     * 异步通知
     * @return mixed
     */
    public function notify();

    /**
     * 测试
     * @return mixed
     */
    public function test();
}