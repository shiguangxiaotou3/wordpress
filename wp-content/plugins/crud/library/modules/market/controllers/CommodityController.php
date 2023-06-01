<?php
namespace crud\modules\market\controllers;

use Yii;
use crud\controllers\AjaxController;
use crud\modules\market\models\Commodity;
class CommodityController  extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Commodity';
    public $modelName ='Commodity';
    public $url_prefix='market';
}