<?php

/**
 *
 *
 * @name AddController.php
 * @author 时光小偷
 * @package wordpress
 * @time  2022-9-27 2:51
 */

namespace console\controllers;
use crud\Base;
use crud\models\Rely;
use Darabonba\GatewaySpi\Models\InterceptorContext\request;
use frontend\web\App;
use Yii;
use crud\library\components\Ads;
use yii\console\Controller;
/**
 * 测试应用
 */
class AddController extends Controller
{

    /**
     * 测试
     */
    public function actionIndex(){
        /** @var Ads $ads */
        $ads = \Yii::$app->ads;
        print_r( $ads-> GetCustomerInfo($ads->customerId));
    }

    /**
     * 删除.DS_Store文件
     */
    public function actionDeleteDsStore(){
        $dir = dirname(__DIR__,5);
        deleteDsStore($dir,".DS_Store");
    }

    /**
     * @return array|string[]
     */
    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            'C' => 'comment',
            'f' => 'fields',
            'p' => 'migrationPath',
            't' => 'migrationTable',
            'F' => 'templateFile',
            'P' => 'useTablePrefix',
            'c' => 'compact',
        ]);
    }

    /**
     * 批量生成模型
     */
    public function actionGii(){
        $ignore =["migration","wp_WechatReplay_keywords"];
        $sql = 'SHOW TABLES';
        $tables = Yii::$app->db->createCommand($sql)->queryAll();
        $cli =[];
        $tables = array_column($tables,"Tables_in_wp");
        foreach ($tables as $table){
            if(!in_array($table,$ignore)){
                $modelClass =toScoreUnder($table);
                $cli[]="php command  gii/model --ns=library\\\\models\\\\wp --modelClass=".
                    $modelClass." --tableName=".$table.
                    " --enableI18N=1 --messageCategory=wp  --useTablePrefix=1";
            }
        }
        file_put_contents(ABSPATH."gii.sh","#!/bin/bash\n".join("\n",$cli));
    }

    public function actionT(){
        $file =Yii::getAlias("@library/messages/wp/zh-CN/wp.php");
        $str = file_get_contents( $file);
        preg_match_all("/\'[^\']*\'/",$str,$data);
        $keys =array_unique($data[0]);
        $result=[];
        foreach ($keys as $key){
            $result[]= $key." =>''";
        }
        $str ="<?php\nreturn [\n".join(",\n",$result)."\n];";

        file_put_contents($file,"<?php\nreturn [\n".join(",\n",$result)."\n];");

    }

    /**
     * http测试
     */
    public function actionHttp(){
       $data =  Base::GET("https://www.baidu.com",[]);
        var_dump($data);
    }


    /**
     * 计算composer 依赖关系图
     */
    public function actionComposer(){
        $model = new Rely();
        $model->vendorDir = Yii::getAlias('@vendor');
//        $model->env = false;
        $model->baseComposerJson = ABSPATH."composer.json";
        $model->baseComposerLock = ABSPATH."composer.lock";
       file_put_contents('./test/index.html',$model->renderHtml());
    }

}