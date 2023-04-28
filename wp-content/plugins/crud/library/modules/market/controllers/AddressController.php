<?php
namespace crud\modules\market\controllers;

use crud\controllers\AjaxController;

class AddressController extends AjaxController
{
    public $modelClass ='crud\modules\market\models\Address';
    public $modelName ='Address';
    public $url_prefix='market';

}