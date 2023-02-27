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

    /**
     * 所属组
     * @param $path
     * @return false|int
     */
    public static function getGroup($path)
    {
        return filegroup($path);
    }

    /**
     * 所属组名称
     * @param $path
     * @return false|int
     */
    public static function getGroupName($path){
       return posix_getgrgid(self::getGroup($path));
    }
    /**
     * 所有者
     * @param $path
     * @return false|int
     */
    public static function getOwner($path)
    {

        return fileowner( $path);
    }

    /**
     * 所有者名称
     * @param $path
     * @return false|int
     */
    public static function getOwnerName($path)
    {
        return posix_getpwuid(self::getOwner( $path));
    }
    /**
     * 获取文件所有者信息
     * @param $path
     * @return array
     */
    public static function getOwnerInfo($path){
        return posix_getpwuid(fileowner($path));
    }

    /**
     * 获取当前目录权限，返回数字
     * @param $path
     * @return false|string|integer
     */
    public static function getPermissionsNumber($path){
        return substr(sprintf('%o', fileperms($path)), -4);
    }

    /**
     * @param $path
     * @return array|bool
     */
    public static function fileInfo($path){
        if(is_dir($path)){
            return [
                'name'=>'',
                'size'=>filesize($path),
                'group'=>self::getGroup($path),
                'owner'=>self::getOwner($path),
                'ownerName'=>posix_getpwuid(fileowner($path))['name'],
                'permissions'=>self::getPermissionsNumber($path),
                'is_writable'=>is_writable($path),
                'is_readable'=>is_readable($path),
                'is_executable'=>is_executable($path)
            ];
        }
        if (is_file($path)){
            $text =file_get_contents($path);
            return [
                'name'=>basename($path),
                'size'=>filesize($path),
                'group'=>self::getGroup($path),
                'owner'=>self::getOwner($path),
                'ownerName'=>posix_getpwuid(fileowner($path))['name'],
                'permissions'=>self::getPermissionsNumber($path),
                'is_writable'=>is_writable($path),
                'is_readable'=>is_readable($path),
                'is_executable'=>is_executable($path),
                'text'=>$text ? $text : "",
            ];
        }
        return  false ;
    }

    /**
     * 获取当前目录下的子目录和文件
     * @param $path
     * @return array[]
     */
    public static function dirList($path){
        if(is_dir($path)){
            $data =['dir'=>[],'files'=>[]];
            if ($handle = opendir($path)) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != "." && $item != "..") {
                        if(is_dir("$path/$item")){
                            $data['dir'][]= $item;
                        }else{
                            if(substr($item,0,1) !="."){
                                $data['files'][]= $item;
                            }

                        }
                    }
                }
                closedir($handle);
                return $data;
            }
        }
    }
}