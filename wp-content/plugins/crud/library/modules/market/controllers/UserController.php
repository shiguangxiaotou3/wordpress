<?php

namespace crud\modules\market\controllers;

use crud\controllers\AjaxController;
use Yii;
use  crud\models\wp\WpUsers;


class UserController  extends AjaxController
{
    public $modelClass ='crud\models\wp\WpUsers';
    public $modelName ='WpUsers';
    public $url_prefix='market';

}