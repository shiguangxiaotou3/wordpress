<?php


namespace crud\modules\market\controllers;

use Yii;
use crud\modules\market\models\Commodity;
use crud\modules\market\controllers\CrudController;
class CommodityController extends CrudController
{
    public $modelClass ='crud\modules\market\models\Commodity';
    public $modelName ='Commodity';
}