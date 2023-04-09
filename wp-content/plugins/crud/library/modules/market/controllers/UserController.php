<?php


namespace crud\modules\market\controllers;
use Yii;
use  crud\models\wp\WpUsers;
use crud\modules\market\controllers\CrudController;

class UserController extends CrudController
{
    public $modelClass ='crud\models\wp\WpUsers';
    public $modelName ='WpUsers';

}