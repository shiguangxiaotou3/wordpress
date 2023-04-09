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
    const EVENT_SUBMIT ='submit';
    const EVENT_NOTIFY ='notify';
    const EVENT_RETURN ='return';


    private $_payEvent;
    /**
     * @return array[]
     */
    public function events()
    {
         $pay_event = $this->payEvent;
        return [
            self::EVENT_SUBMIT => [$this->payEvent,'submitEvent'],
            self::EVENT_NOTIFY => [$this->payEvent,'notifyEvent'],
            self::EVENT_RETURN=>[$this->payEvent,'returnEvent']
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