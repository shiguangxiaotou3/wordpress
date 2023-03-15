<?php
namespace crud\components;

use yii\web\Response  as YiiResponse;
use yii\web\HeadersAlreadySentException;
class Response extends YiiResponse
{
    public function send()
    {
        if ($this->isSent) {
            return;
        }
        $this->trigger(self::EVENT_BEFORE_SEND);
        $this->prepare();
        $this->trigger(self::EVENT_AFTER_PREPARE);
        $this->sendContent();
        $this->trigger(self::EVENT_AFTER_SEND);
        $this->isSent = true;
    }
}