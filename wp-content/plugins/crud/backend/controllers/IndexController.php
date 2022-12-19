<?php



namespace backend\controllers;


use yii\web\Controller;


/**
 * Class IndexController
 * @package crud\backend\controllers
 */
class IndexController extends Controller
{
    public $enableCsrfValidation=false;
    public $layout=false;

    public function actions()
    {
        return [
            'index',
            'test',
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => false
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
    public function actionTest()
    {
        return $this->render("test");
    }


}