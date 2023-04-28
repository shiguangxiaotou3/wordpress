<?php
namespace crud\modules\market\controllers;

use Yii;
use crud\controllers\ApiController;
use crud\controllers\AjaxController;
use crud\modules\market\models\Storehouse;
use crud\modules\market\controllers\CrudController;

class StorehouseController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Storehouse';
    public $modelName ='Storehouse';
    public $url_prefix='market';
}