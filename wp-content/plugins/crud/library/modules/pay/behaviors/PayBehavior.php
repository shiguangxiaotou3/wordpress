<?php


namespace crud\modules\pay\behaviors;
use crud\modules\pay\events\PayEvent;
use yii\base\Behavior;
use yii\base\Event;

/**
 * Class PayBehavior
 *
 * @property-read  PayEvent $payEvent
 * @package crud\modules\pay\behaviors
 */
class PayBehavior extends Behavior
{

     //创建订单之前校验数据
    const EVENT_BEFORE_SUBMIT ='beforeSubmit';

    //创建订单之后保持数据到mysql
    const EVENT_AFTER_SUBMIT ='afterSubmit';

    //异步通知mysql数据
    const EVENT_BEFORE_NOTIFY ='beforeNotify';
    // 异步通知用于发生通知
    const EVENT_AFTER_NOTIFY ='afterNotify';
    // 同步跳转处理
    const EVENT_RETURN ='return';
    // 错误处理
    const EVENT_ERROR ='error';

    private $_payEvent;
    /**
     * @return array[]
     */
    public function events()
    {
        return [
            self::EVENT_BEFORE_SUBMIT => [$this->payEvent,'beforeSubmitEvent'],
            self::EVENT_AFTER_SUBMIT  => [$this->payEvent,'afterSubmitEvent'],
            self::EVENT_BEFORE_NOTIFY => [$this->payEvent,'beforeNotifyEvent'],
            self::EVENT_AFTER_NOTIFY => [$this->payEvent,'afterNotifyEvent'],
            self::EVENT_RETURN=>[$this->payEvent,'returnEvent'],
            self::EVENT_ERROR=>[$this->payEvent,'errorEvent']
        ];
    }

    /**
     * @return PayEvent
     */
    public function getPayEvent(){
        if(!isset($this->_payEvent)  or empty($this->_payEvent)){
            $this->_payEvent = new PayEvent();;
        }
        return $this->_payEvent;
    }

}