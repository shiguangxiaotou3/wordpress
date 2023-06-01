<?php

namespace crud\modules\base\controllers;

use crud\controllers\AjaxController;
class MovieController extends AjaxController
{

    public $modelClass ='crud\modules\movie\models\Movie';
    public $modelName ='Movie';
    public $url_prefix='base';
}