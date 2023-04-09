<?php


namespace crud\modules\market\controllers;

use Yii;
use crud\modules\market\models\Money;
use crud\modules\market\controllers\CrudController;
class MoneyController extends CrudController
{
    public $modelClass ='crud\modules\market\models\Money';
    public $modelName ='Money';
}