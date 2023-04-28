<?php


namespace crud\modules\market\components;

use Yii;
use yii\base\BaseObject;


/**
 * Class Tencent
 * @property \crud\modules\pay\components\WechatPay $pay 微信支付
 * @property \crud\modules\market\components\WechatApplet $applet 微信小程序
 * @property \crud\modules\wechat\components\SubscriptionService $subscription 微信公众号
 * @package crud\modules\market\components
 */
class Tencent extends BaseObject
{


    /**
     * @return crud\modules\pay\components\WechatPay
     */
    public function getPay(){
        return Yii::$app->wechatpay;
    }

    /**
     * @return \crud\modules\market\components\WechatApplet
     */
    public function getApplet(){
        return Yii::$app->wechatApplet;
    }

    /**
     * @return crud\modules\wechat\components\SubscriptionService
     */
    public function getSubscription(){
        return Yii::$app->subscription;
    }
}