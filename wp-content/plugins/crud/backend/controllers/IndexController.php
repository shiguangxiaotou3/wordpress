<?php



namespace backend\controllers;


use yii\web\Controller;


/**
 * Class IndexController
 * @package crud\backend\controllers
 */
class IndexController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render("index");
    }

    /**
     * @return string
     */
    public function actionTest()
    {
        return $this->render("test");
    }

    /**
     * @return string
     */
    public function actionError()
    {
        return $this->render("error");
    }

    /**
     * @return string
     */
    public function actionSettings()
    {
        return $this->render("settings");
    }
}