<?php


namespace crud\modules\pay\controllers;


use crud\controllers\AjaxController;

class OrderController extends AjaxController
{

    public $modelClass ='crud\modules\pay\models\Order';
    public $modelName ='Order';
    public $url_prefix='pay';
}