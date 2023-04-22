<?php


namespace crud\modules\market\controllers;


use crud\controllers\AjaxController;
use Yii;
use crud\modules\market\models\Categorize;
class CategorizeController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Categorize';
    public $modelName ='Categorize';
    public $url_prefix='market';

}