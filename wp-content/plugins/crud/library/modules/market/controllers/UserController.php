<?php

namespace crud\modules\market\controllers;

use Yii;
use  crud\models\wp\WpUsers;
use crud\controllers\AjaxController;

class UserController  extends AjaxController
{
    public $modelClass ='crud\models\wp\WpUsers';
    public $modelName ='WpUsers';
    public $url_prefix='market';

}