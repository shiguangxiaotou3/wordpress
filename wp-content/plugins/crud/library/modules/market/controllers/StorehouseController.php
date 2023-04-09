<?php


namespace crud\modules\market\controllers;

use Yii;
use crud\modules\market\models\Storehouse;
use crud\controllers\ApiController;
use crud\modules\market\controllers\CrudController;
class StorehouseController extends CrudController
{
    public $modelClass ='crud\modules\market\models\Storehouse';
    public $modelName ='Storehouse';
}