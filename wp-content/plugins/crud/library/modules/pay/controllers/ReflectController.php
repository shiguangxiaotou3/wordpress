<?php

namespace crud\modules\pay\controllers;

use crud\controllers\AjaxController;

class ReflectController extends AjaxController
{

    public $modelClass ='crud\modules\pay\models\Reflect';
    public $modelName ='Reflect';
    public $url_prefix='pay';
}