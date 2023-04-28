<?php

namespace crud\modules\wechat\controllers;

use crud\controllers\AjaxController;

class WechatMessageController extends AjaxController
{
    public $modelClass ='crud\modules\wechat\models\WechatMessage';
    public $modelName ='WechatMessage';
    public $url_prefix='wechat';
}