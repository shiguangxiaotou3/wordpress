<?php


namespace crud\models\wechat;


use yii\base\BaseObject;

class SubscriptionServiceError extends BaseObject
{

    public static function getErrorMessages(){
        return [
            -1 => "系统繁忙，此时请开发者稍候再试",
            0 => "请求成功",
            40001 => "AppSecret错误或者 AppSecret 不属于这个公众号，请开发者确认 AppSecret 的正确性",
            40002 => "请确保grant_type字段值为client_credential",
            40164 => "调用接口的 IP 地址不在白名单中，请在接口 IP 白名单中进行设置。",
            89503 => "此 IP 调用需要管理员确认,请联系管理员",
            89501 => "此 IP 正在等待管理员确认,请联系管理员",
            89506 => "24小时内该 IP 被管理员拒绝调用两次，24小时内不可再使用该 IP 调用",
            89507 => "1小时内该 IP 被管理员拒绝调用一次，1小时内不可再使用该 IP 调用",
        ];
    }

    public static function getError($code){
        return self::getErrorMessages()[$code];
    }

}