<?php


namespace crud\modules\market\controllers;

use crud\controllers\AjaxController;
use Yii;
use crud\modules\market\models\Money;

class MoneyController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Money';
    public $modelName ='Money';
    public $url_prefix='market';
}