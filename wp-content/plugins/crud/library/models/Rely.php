<?php


namespace crud\models;


use yii\base\Model;

/**
 * 生成composer 依赖关系图
 * @package crud\models
 */
class Rely extends Model
{

    public $vendorDir = '';
    public $baseComposerJson = '';
    public $baseComposerLock='';
    public $env = true;
    public $_require=[];
    public $projectName="shiguangxiaotou/wordpress";
    public $data =[
        "nodes" => [
            [
                "id" => "0",
                "name" => "shiguangxiaotou/wordpress",
                "symbolSize" => 20,
                "value" => "1.3.0",
                "category" => 0
            ],
        ],
        "links" => [],
        "categories" => [
            [
                "name" => "A"
            ]
        ]
    ];

    /**
     * 获取已安装拓展包已安装版本
     * @param $projectName
     * @return mixed|string
     */
    public function getVersion($projectName){
        $str_json = file_get_contents($this->baseComposerLock);
        $arr = json_decode($str_json,true);
        $packages = ($this->env) ? $arr['packages']:$arr['packages-dev'];
        $results ='';
        foreach ( $packages as $package){
            if($package['name']==$projectName){
                return $package['version'];
            }
        }
        return  $results;
    }

    /**
     * 获取拓展id
     * @param $projectName
     * @return int|mixed
     */
    public function getFatherId($projectName){
        $fatherId =0;
        foreach ($this->data['nodes'] as $node){
            if($node['name'] == $projectName){
                return $node['id'];
            }
        }
        return  $fatherId;
    }

    /**
     * 获取composer.json的依赖包名称
     * @param $file
     * @return array
     */
    public  function getRequire($file){
        $requires = $names=[];
        if(file_exists($file)){
            $json = file_get_contents($file);
            $arr =json_decode($json,true);
            if($this->env){
                $requires = !empty($arr['require'])? $arr['require']:[];
            }else{
                $requires = !empty($arr['require-dev'])? $arr['require-dev']:[];
            }
            $names = array_keys($requires);
        }
        return $names;
    }

    /**
     * 递归获取所以第三方插件
     * @param $projectName
     */
    public  function getRely($projectName){
        if(!in_array($projectName,$this->_require)){
            array_push($this->_require,$projectName);
        }
        $tmp = self::getRequire($this->vendorDir.'/'.$projectName."/composer.json");
        if(!empty($tmp)) {
            foreach ($tmp as $value) {
                self::getRely($value);
            }
        }
    }

    public function isset_node($projectName){
        foreach ($this->data['nodes'] as $node){
            if($node['name'] == $projectName){
                return true;
            }
        }
        return  false;
    }

    public function getData(){
        $base = $this->getRequire($this->baseComposerJson);
        foreach ($base as $value){
            $this->getRely($value);
        }
        return $this->data;
    }

    public function getJson(){
      $projectNames = $this->getRequireAll();

    }
    public function getRequireAll(){
        $base = $this->getRequire($this->baseComposerJson);
        foreach ($base as $value){
            $this->getRely($value);
        }
        return $this->_require;
    }

}