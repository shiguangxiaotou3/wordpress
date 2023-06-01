<?php

namespace backend\controllers;

use yii\web\Controller;
/**
 * Class IndexController
 * @package crud\backend\controllers
 */
class IndexController extends Controller
{
    public $enableCsrfValidation = false;

    public $layout = false;

    public function actions()
    {
        return [
            'index',
            'modules',
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render("index");
    }

    /**
     * @return string
     */
    public function actionModules()
    {
        return $this->render("modules");
    }

    public function actionRules(){
        return $this->render('rules');
    }

    public function actionIcons(){
        return $this->render("icons");
    }
    public function actionStyle(){
        return $this->render("style");
    }

    public function actionError(){
        return $this->render('error');
    }
}