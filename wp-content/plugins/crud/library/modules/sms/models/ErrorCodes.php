<?php


namespace crud\modules\sms\models;

use crud\modules\sms\models\RequestError;
class ErrorCodes extends RequestError
{
    public function checkExist($errorCode)
    {
        return array_key_exists($errorCode, $this->errorCodes);
    }
}