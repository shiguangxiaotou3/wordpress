<?php


namespace  crud\components\wechat;

use  yii\base\Component;

/**
 * 微信公众好组件
 * @property $appId appi
 * @property $appSecret
 * @public $token
 * @property-read $accessToken
 * @package crud\common\components\webxin
 */
class SubscriptionService extends Component
{

    const Production = "Production";
    const Development ="Development";
    public $environment = self::Development;
    public $appId ="wx50c8135617e4df61";
    public $appSecret ="6bdd98a76a504e838b7dc4ef8f81d527";
    public $token ="asdasda";
    public $_accessToken;

    public function getAccessToken(){

    }
}