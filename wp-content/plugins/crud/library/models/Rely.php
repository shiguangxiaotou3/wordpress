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
//            [
//                "id" => "0",
//                "name" => "shiguangxiaotou/wordpress",
//                "symbolSize" => 20,
//                "value" => "1.3.0",
//                "category" => 0
//            ],
        ],
        "links" => [
//            "source" => $nodeId,
//            "target" => $fatherId
        ],
        "categories" => [
//            ['name'=>'adads']
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
     * 获取composer.json的依赖包名称
     * @param $file
     * @param bool $env
     * @return array
     */
    public static function getRequire($file,$env=true){
        $requires = $names=[];
        if(file_exists($file)){
            $json = file_get_contents($file);
            $arr =json_decode($json,true);
            if($env){
                $requires = !empty($arr['require'])? $arr['require']:[];
            }else{
                $requires1 = !empty($arr['require'])? $arr['require']:[];
                $requires2 = !empty($arr['require-dev'])? $arr['require-dev']:[];
                $requires = array_merge($requires1,$requires2);
//                $requires = !empty($arr['require-dev'])? $arr['require-dev']:[];
//                logObject($requires2);
            }
            $names = array_keys($requires);
        }
        return $names;
    }

    /**
     * 递归获取所以第三方插件
     * @param array $data
     * @param $projectName
     */
    public  function getRely($projectName,&$data=[]){
        $tmp = self::getRequire($this->vendorDir.'/'.$projectName."/composer.json");
        if(!empty($tmp)) {
            foreach ($tmp as $value) {
                $data[$projectName][$value]=[] ;
                $tmp2 =self::getRequire($this->vendorDir.'/'.$value."/composer.json");
                if(!empty($tmp2)){
                    self::getRely($value,$data[$projectName][$value]);
                }

            }
        }
    }

    /**
     * 判断节点是否存在
     * @param $projectName
     * @return bool
     */
    public function isset_node($projectName){
        foreach ($this->data['nodes'] as $node){
            if($node['name'] == $projectName){
                return true;
            }
        }
        return  false;
    }

    /**
     * 获取节点id
     * @param $nodeName
     * @return mixed
     */
    public  function getNodeId($nodeName){
        foreach ($this->data['nodes'] as $node){
            if($node['name'] == $nodeName){
                return $node['id'];
            }
        }
    }

    /**
     * 递归创建Echarts数据结构
     * @param $fatherId
     * @param $categoryId
     * @param $nodeName
     * @param $nodes
     * @param $data
     */
    public  function  recursionNodes($fatherId,$categoryId,$nodeName,$nodes,&$data){
        if(!$this->isset_node($nodeName)){
            $nodeId =count($data['nodes']);
            if($nodeId ==0){
                $data['nodes'][]=[
                    "id" => $nodeId,
                    "name" => $nodeName,
                    "symbolSize" => 20,
                    "value" => $this->getVersion($nodeName),
                    "category" => $categoryId
                ];
            }else{
                $data['nodes'][]=[
                    "id" => $nodeId,
                    "name" => $nodeName,
                    "value" => $this->getVersion($nodeName),
                    "category" => $categoryId
                ];
            }

            if($nodeId !==$fatherId){
                $data['links'][]=[
                    "source" => $nodeId,
                    "target" => $fatherId
                ];
            }
        }else{
            $nodeId = $this->getNodeId($nodeName);
            // 要现实复杂依赖关系,请取消注释
//            if($nodeId !==$fatherId){
//                $data['links'][]=[
//                    "source" => $nodeId,
//                    "target" => $fatherId
//                ];
//            }
        }



        if (!empty($nodes)){
            $categoryId = count( $this->data["categories"]);
            $this->data["categories"][]=["name"=>$nodeName];
            foreach ($nodes as $name=>$v){
                $this->recursionNodes($nodeId,$categoryId,$name,$v,$data);
            }
        }

    }


    /**
     * 解析依赖,并创建eCharts数据结构
     * @return array
     */
    public function getRequireAll(){
        // 获取所有加载的拓展
        $base = self::getRequire($this->baseComposerJson,$this->env);
        $this->_require[$this->projectName]=[];
        foreach ($base as $value){
            $this->_require[$this->projectName][$value]=[];
            $this->getRely($value, $this->_require[$this->projectName][$value]);
        }
        $results = $this->_require;
        $nodeId = $categoriesId = 0;
        foreach ($results as $key =>$value){
            $this->recursionNodes($nodeId,$categoriesId,$key,$value,$this->data);
            $categoriesId++;
        }
       return  $this->data;
    }

    /**
     * 直接生成html文件
     * @return string
     */
    public function renderHtml(){
        $json_str = json_encode( $this->getRequireAll(),true);
        return <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <title>Document</title>
</head>
<body>
    <div id="container" style="width: 100%;height: 800px"></div>
</body>
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/jquery"></script>
<script type="text/javascript" src="https://fastly.jsdelivr.net/npm/echarts@5.4.0/dist/echarts.min.js"></script>
<script>
    var dom = document.getElementById('container');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',useDirtyRect: false
    });
    var graph = {$json_str}
    var option= {
      tooltip: {},
      legend: [
        {
          data: graph.categories.map(function (a) {
            return a.name;
          })
        }
      ],
      series: [
        {
          name: 'shiguangxiaotou/crud',
          type: 'graph',
          layout: 'force',
          data: graph.nodes,
          links: graph.links,
          categories: graph.categories,
          roam: true,
          label: {
            show: true,
            position: 'right',
            formatter: '{b}'
          },
          labelLayout: {
            hideOverlap: true
          },
          scaleLimit: {
            min: 2,
            max: 10
          },
          lineStyle: {
            color: 'source',
            curveness: 0.3
          }
        }
      ]
    };
    myChart.showLoading();
    myChart.hideLoading();
    myChart.setOption(option);
    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }
    window.addEventListener('resize', myChart.resize);
</script>
</html>
HTML;
    }

}