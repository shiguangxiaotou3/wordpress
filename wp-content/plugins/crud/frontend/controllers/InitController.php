<?php


namespace frontend\controllers;


use crud\assets\HighlightAsset;
use yii\web\Controller;
use yii\web\View;

class InitController extends Controller
{

    public $layout =false;

    public function actionIndex(){

        return $this->render("index");
    }




}