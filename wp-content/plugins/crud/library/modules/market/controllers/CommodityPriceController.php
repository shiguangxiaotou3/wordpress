<?php


namespace crud\modules\market\controllers;

use Yii;
use crud\modules\market\models\CommodityPrice;
use crud\modules\market\controllers\CrudController;
class CommodityPriceController extends CrudController
{
    public $modelClass ='crud\modules\market\models\CommodityPrice';
    public $modelName ='CommodityPrice';
}