<?php
namespace crud\modules\wp\controllers;

use Yii;
use crud\models\Files;
use yii\web\Controller;

class IndexController extends Controller
{
    public $layout ='webslides';

    /**
     * @return string
     */
    public function actionIndex(){
        return $this->render("index");
    }

    /**
     * @return string
     */
    public function actionTest(){
        return $this->render("test");
    }

    /**
     * @return string
     */
    public function actionError(){
        return $this->render("error");
    }

    /**
     * @return string
     */
    public function actionDocs(){
        return $this->render("docs");
    }

    public function actionIcons(){
        return $this->render("icons");
    }
    /**
     * @return string
     */
    public function actionWap(){
        return $this->render("wap");
    }
    /**
     * @return string
     */
    public function actionAce(){
        if(Yii::$app->request->isAjax){
            $path = Yii::$app->request->get('path',"@docs");
            if(substr($path, 0, 5) === "@docs"){
               $path = Yii::getAlias($path);
               $list =[];
               if(is_dir($path)){
                   $list = $this->getPathList($path);
               }
               $info = Files::fileInfo($path);
                return $this->success('ok',[
                    'info' => $info,
                    'list' => $list,
//                    'path'=>$path,
                ]);
            }else{
                return  $this->error('文件非法');
            }
        }
        $this->layout ='break';
        return $this->render("ace");
    }

    public function actionMovie(){
        return $this->render('movie');
    }
    public function getPathList($path){
        if(is_dir($path)){
            $handle = opendir($path);
            $result =[];
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    if(is_file($path."/".$file)){
                        $result[] = ['type' => 'file', 'name' => $file];
                    }elseif(is_dir($path."/".$file)){
                        $result[] = ['type' => 'dir', 'name' => $file];
                    }
                }
            }
            return $result;
        }else{
            return [];
        }

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