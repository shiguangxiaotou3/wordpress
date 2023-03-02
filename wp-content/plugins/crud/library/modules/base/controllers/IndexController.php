<?php


namespace crud\modules\base\controllers;

use crud\models\Files;
use Yii;
use yii\web\Controller;
use yii\web\Response;

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
        $request = Yii::$app->request;
        if($request->isAjax){
            $ips = $request->get("ips");
            $ips = explode(",",$ips);
            $crawlers = Yii::$app->crawlers;
            $results =[];
            foreach ($ips as $ip){
                $re =$crawlers->getIpinfo($ip);
                $results[] = [
                    "latLng" => explode(",", $re["loc"]),
                    "name" => Yii::t("city", $re["city"])
                ];
            }
           return  $this->success('ok', $results);
        }
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


    public function error($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 0,
            'message' => $message,
            'time' => time(),
            'data' => $data
        ]);
    }

    public function success($message, $data = [],$header=[])
    {
        header('Content-Type: application/json');
        return json_encode([
            'code' => 1,
            'message' => $message,
            'time' => time(),
            'data' => $data,
        ]);
    }

}