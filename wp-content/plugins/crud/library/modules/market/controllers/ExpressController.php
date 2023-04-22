<?php


namespace crud\modules\market\controllers;

use crud\controllers\AjaxController;
use Yii;
use crud\modules\market\models\Express;
class ExpressController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Express';
    public $modelName ='Express';
    public $url_prefix='market';
}