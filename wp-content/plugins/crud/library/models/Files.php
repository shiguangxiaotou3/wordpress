<?php


namespace crud\models;

use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;
class Files extends Model
{

    /**
     * @param $alias
     * @return array
     */
    public static  function getCssFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.css']]);
            if(!empty($files)){

                foreach ($files as $file){
                    $results[] = basename($file);
                }
            }
            return $results;
        }
        return  [];
    }

    /**
     * @param $alias
     * @return array
     */
    public static function getPhpFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.php']]);
            if(!empty($files)){

                foreach ($files as $file){
                    $results[] =basename($file);
                }
            }
            return $results;
        }
        return  [];
    }
    /**
     * @param $alias
     * @return array
     */
    public static function getJsonFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.json']]);
            if(!empty($files)){

                foreach ($files as $file){
                    $results[] =basename($file);
                }
            }
            return $results;
        }
        return  [];
    }
    /**
     * @param $alias
     * @return array
     */
    public static function getTxtFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.txt']]);
            if(!empty($files)){

                foreach ($files as $file){
                    $results[] =basename($file);
                }
            }
            return $results;
        }
        return  [];
    }
    /**
     * @param $alias
     * @return array
     */
    public static function getHtmlFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.html']]);
            if(!empty($files)){

                foreach ($files as $file){
                    $results[] =basename($file);
                }
            }
            return $results;
        }
        return  [];
    }

    /**
     * @param $alias
     * @return array
     */
    public static function getJsFiles($alias){
        $path= Yii::getAlias($alias);
        if(is_dir($path)){
            $results =[];
            $files = FileHelper::findFiles( $path,['only'=>['*.js']]);
            if(!empty($files)){
                foreach ($files as $file){
                    $results[] =basename($file);
                }
            }
            return $results;
        }
        return  [];
    }
}