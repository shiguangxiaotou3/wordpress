<?php


namespace crud\modules\base\controllers;

use Yii;
use yii\web\Controller;




class IndexController extends Controller
{

    public $enableCsrfValidation=false;

    public function actions(){
        return [
            "index","ipinfo","mail","dns",'jvectormap','highlight',"crawlers"
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
    public function actionJvectormap(){
        return $this->render("jvectormap");
    }

    public function actionCrawlers(){
        return $this->render("crawlers");
    }

}