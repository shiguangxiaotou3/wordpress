<?php


namespace crud\modules\base\controllers;

use crud\models\Files;
use Yii;
use yii\web\Controller;

class IndexController extends Controller
{

    public $enableCsrfValidation=false;

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

    /**
     * 爬虫检测
     * @return string
     */
    public function actionCrawlers(){
        return $this->render("crawlers");
    }

    /**
     * 阿里云Oss
     * @return string
     */
    public function actionOss(){
        return $this->render("oss");
    }

    /**
     * 阿里云Oss
     * @return string
     */
    public function actionEditor(){
        $request=  Yii::$app->request;
        if($request->isAjax){
            $baseDir = $request->get("baseDir");
            if(empty($baseDir)){
                $baseDir =CRUD_DIR;
            }
            $type = $request->get('type');
            if( $type == "List"){
                return Files::dirList($baseDir);
            }

        }
        return $this->render("editor");
    }


    public function actionIcons(){
        return $this->render("icons");
    }

}