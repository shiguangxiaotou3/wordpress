<?php
namespace crud\modules\wechat\components;

use crud\modules\wechat\components\SubscriptionService;

/**
 * Class SubscribeSettings
 * @property-read
 * @package crud\modules\wechat\components
 */
class SubscribeSettings extends SubscriptionService{

    //选用模板
    public function addTemplate(){

    }
    // 删除模板
    public function deleteTemplate(){

    }
    // 获取公众号类目
    public function getCategory(){

    }
    // 获取模板中的关键词
    public function getPubTemplateKeyWordsById(){

    }
    // 获取所属类目的公共模板
    public function getPubTemplateTitleList(){

    }
    // 获取私有模板列表
    public function getTemplateList(){

    }
    // 发送订阅通知 同时可以接收事件推送
    public function send(){}
}