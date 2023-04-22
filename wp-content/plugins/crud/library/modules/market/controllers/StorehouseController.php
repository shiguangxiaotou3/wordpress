<?php


namespace crud\modules\market\controllers;

use crud\controllers\AjaxController;
use Yii;
use crud\modules\market\models\Storehouse;
use crud\controllers\ApiController;
use crud\modules\market\controllers\CrudController;
class StorehouseController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Storehouse';
    public $modelName ='Storehouse';
    public $url_prefix='market';
}