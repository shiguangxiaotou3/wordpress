<?php
namespace crud\modules\market\controllers;

use Yii;
use crud\controllers\AjaxController;
use crud\modules\market\models\CommodityPrice;

class CommodityPriceController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\CommodityPrice';
    public $modelName ='CommodityPrice';
    public $url_prefix='market';
}