<?php


namespace backend\controllers;

use Yii;
use Exception;
use yii\web\Controller;
use yii\web\Response;
/**
 * Class SettingsController
 * @package crud\backend\controllers
 */
class SettingsController extends Controller{

    public $enableCsrfValidation=false;

    public function actions(){
       return [
           "index","translate","ipinfo","mail","dns",'jvectormap','highlight',"preCode","crawlers"
       ];
    }

    public $layout=false;

    /**
     * @return string
     */
    public function actionIndex(){

        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionTranslate(){
        return $this->render("translate");
    }

    /**
     * @return string
     */
    public function actionIpinfo()
    {
        return $this->render("ipinfo");
    }

    /**
     * @return string
     */
    public function actionMail()
    {
        return $this->render("mail");
    }

    /**
     * @return string
     */
    public function actionDns()
    {
        return $this->render("dns");
    }

    /**
     * @return string
     */
    public function actionHighlight(){
        return $this->render("highlight");
    }

    /**
     * @return string
     */
    public function actionPreCode(){
        return $this->render("precode");
    }

    /**
     * @return string
     */
    public function actionJvectormap(){
        return $this->render("jvectormap");
    }

    public function actionCrawlers(){
        return $this->render("crawlers");
    }

}