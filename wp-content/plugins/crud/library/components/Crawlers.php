<?php


namespace crud\components;
use Yii;
use Exception;
use yii\base\Component;
use crud\models\Color;
use Jaybizzle\CrawlerDetect\CrawlerDetect;


/**
 *
 * @property-read  string $path
 * @property-read $activeDir
 * @package crud\common\components
 */
class Crawlers extends Component{

    public $tmp ="@common/runtime";
    public $_path="";
    public $ignore=["127.*","192.168.*"];
    public function getPath(){
        return !empty($this->_path) ? $this->_path : Yii::getAlias($this->tmp);
    }
    /**
     * @return bool
     */
    public function isCrawler(){
        return  (new CrawlerDetect)->isCrawler();
    }

    /**
     * 获取
     */
    public function getMatches(){
        return  (new CrawlerDetect)->getMatches();
    }

    /**
     * 获取来路信息
     */
    public function getReferer(){
//        preg_match('#((http://)|(https://))?([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}#',$_SERVER["HTTP_REFERER"],$url);
        return isset( $_SERVER["HTTP_REFERER"]) ?$_SERVER["HTTP_REFERER"]:"";
    }

    /**
     * @return string|null
     */
    public function getIp(){
        global $crud;
        return $crud->frontend->request->userIP;
    }

    /**
     * @param $ip
     */
    public function getAnalysisIp($ip){
        $token = get_option("crud_group_ipinfo_token");
        if(!empty($token)){
            return json_decode( file_get_contents("https://ipinfo.io/".$ip."?token=".$token),true);
        }
    }

    /**
     * @param $ip
     * @return mixed
     */
    public function getIpinfo($ip){
        try{
            $path =  $this->path. "/ipinfo";
            if(file_exists($path."/".$ip.".data")){
                return unserialize(file_get_contents($path."/".$ip.".data"));
            }else{
                $data =$this->getAnalysisIp($ip);
                if(isset($data["city"]) and isset($data["region"]) and isset($data["country"]) and isset($data["loc"])){
                    file_put_contents($path."/".$ip.".data",serialize($data ));
                    return  $data ;
                }else{
                    return false;
                }
            }
        }catch (Exception $exception){
            echo $exception->getMessage();
        }

    }

    /**
     * 判断用户浏览器
     * @return string
     */
    public function getBrowser(){
        $user_OSagent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_OSagent, "Maxthon") && strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "Maxthon(Microsoft IE)";
        } elseif (strpos($user_OSagent, "Maxthon 2.0")) {
            $visitor_browser = "Maxthon 2.0";
        } elseif (strpos($user_OSagent, "Maxthon")) {
            $visitor_browser = "Maxthon";
        } elseif (strpos($user_OSagent, "MSIE 9.0")) {
            $visitor_browser = "MSIE 9.0";
        } elseif (strpos($user_OSagent, "MSIE 8.0")) {
            $visitor_browser = "MSIE 8.0";
        } elseif (strpos($user_OSagent, "MSIE 7.0")) {
            $visitor_browser = "MSIE 7.0";
        } elseif (strpos($user_OSagent, "MSIE 6.0")) {
            $visitor_browser = "MSIE 6.0";
        } elseif (strpos($user_OSagent, "MSIE 5.5")) {
            $visitor_browser = "MSIE 5.5";
        } elseif (strpos($user_OSagent, "MSIE 5.0")) {
            $visitor_browser = "MSIE 5.0";
        } elseif (strpos($user_OSagent, "MSIE 4.01")) {
            $visitor_browser = "MSIE 4.01";
        } elseif (strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "MSIE 较高版本";
        } elseif (strpos($user_OSagent, "NetCaptor")) {
            $visitor_browser = "NetCaptor";
        } elseif (strpos($user_OSagent, "Netscape")) {
            $visitor_browser = "Netscape";
        } elseif (strpos($user_OSagent, "Chrome")) {
            $visitor_browser = "Chrome";
        } elseif (strpos($user_OSagent, "Lynx")) {
            $visitor_browser = "Lynx";
        } elseif (strpos($user_OSagent, "Opera")) {
            $visitor_browser = "Opera";
        } elseif (strpos($user_OSagent, "Konqueror")) {
            $visitor_browser = "Konqueror";
        } elseif (strpos($user_OSagent, "Mozilla/5.0")) {
            $visitor_browser = "Mozilla";
        } elseif (strpos($user_OSagent, "Firefox")) {
            $visitor_browser = "Firefox";
        } elseif (strpos($user_OSagent, "U")) {
            $visitor_browser = "Firefox";
        } else {
            $visitor_browser = 'unknown';
        }
        return $visitor_browser;

    }

    public function ignore($ip){
        foreach ($this->ignore as $item){
            if(preg_match("#".$item."#",$ip)){
                return false;
            }
        }
        return true;
    }

    public function auto(){
        $ip = $this->getIp();
        if ($this->ignore($ip)) {
            $ipinfo = $this->getIpinfo($ip);

            if((isset($ipinfo['city']) and !empty($ipinfo['city']))){
                upDateConfig(
                    Yii::getAlias("@library/messages/city/zh-CN/city.php"),
                    [$ipinfo['city']=>""]
                );
            }
            if((isset($ipinfo['region']) and !empty($ipinfo['region']))){
                upDateConfig(
                    Yii::getAlias("@library/messages/region/zh-CN/region.php"),
                    [$ipinfo['region']=>""]
                );
            }
            $data = [
                "time"=>time(),
                "ip" => $ip,
                "city" => isset( $ipinfo['city'])?$ipinfo["city"]:"",
                "region" =>  isset($ipinfo["region"]) ? $ipinfo["region"]:"",
                "country" => isset( $ipinfo["country"])?$ipinfo["country"]:"",
                "loc" =>  isset($ipinfo["loc"]) ?$ipinfo["loc"]:"",
                "browser" =>  $this->getBrowser(),
                'referer' => $this->getReferer(),
                "isCrawler" => $this->isCrawler(),
                "matches" => $this->getMatches(),
                'dome'=> isset($_SERVER["HTTP_HOST"])? $_SERVER["HTTP_HOST"]:"",
                "url"=> isset($_SERVER["HTTP_SELF"])? $_SERVER["HTTP_SELF"]:"",
                "args"=>  isset($_SERVER["QUERY_STRING"])?$_SERVER["QUERY_STRING"]:"" ,
                'action' => Yii::$app->request->baseUrl,
            ];
            $this->updateRecords($data);
            // 统计客户端浏览器类型
            if (!empty($data["browser"]) and $data["browser"] !== "unknown") {
                $this->updateBrowsers($data['browser']);
            }
            // 统计客户端来路信息
            if ($data["referer"] !==get_option("siteurl")){

            }

            // 统计机器人
            if (!empty($data['Matches'])) {
                $this->updateMatches($data['Matches'], $ip);
            }
        }
    }

    /**
     * 获取数据
     * @param $path
     * @return array|mixed
     */
    public static function getData($path){
        return file_exists($path) ? unserialize(file_get_contents($path)) :[];
    }

    /**
     * 保存数据
     * @param $path
     * @param $data
     */
    public static function saveData($path,$data){
        file_put_contents($path,serialize($data));
    }

    /**
     * 当天Unix时间错
     * @return false|int
     */
    public static function getDayUnix(){
        date_default_timezone_set('Asia/Shanghai');
        return  strtotime(date("Y-m-d"));
    }

    /**
     * 当天的数据访问量
     */
    public  function getActiveDir(){
        $dir = $this->path."/visits/".self::getDayUnix();
        if(!is_dir($dir)){
            mkdir($dir,0777);
        }
        return  $dir;
    }

    /**
     * 更新当天访问记录
     * @param $records
     */
    public  function updateRecords($records){
        $file = $this->activeDir."/records.data";
        $data = self::getData($file);
        $data[time()]= $records;
        self::saveData($file,$data);
    }

    /**
     * 获取访问记录
     * @param integer|null $dayUnix
     */
    public  function getRecords($dayUnix=''){
        if(empty($dayUnix)){
            $dayUnix = self::getDayUnix();
        }
        $file = $this->path."/visits/". $dayUnix."/records.data";;
        return self::getData($file);
    }

    /**
     * 根据浏览器统计
     * @param $browser
     */
    public  function  updateBrowsers($browser){
        $file =$this->activeDir."/browser.data";
        $data =self::getData($file);
        if(isset($data[$browser])){
            $data[$browser]++;
        }else{
            $data[$browser]=1;
        }
        self::saveData($file,$data);
    }

    /**
     * @param $dayUnix
     * @return array|mixed
     */
    public function getBrowsers($dayUnix=''){
        if(empty($dayUnix)){
            $dayUnix = self::getDayUnix();
        }
        $file = $this->path."/visits/". $dayUnix."/browser.data";
        return self::getData($file);
    }

    /**
     * @param $action
     */
    public  function updateAction($action){
        $file = $this->activeDir."/active.data";
        $data = self::saveData($file);
        if(isset($data[$action])){
            $data[$action]++;
        }else{
            $data[$action]=1;
        }
        self::saveData($file,$data);
    }

    /**
     * @param $dayUnix
     * @return array|mixed
     */
    public function getAction($dayUnix=''){
        if(empty($dayUnix)){
            $dayUnix = self::getDayUnix();
        }
        $file = $this->path."/visits/". $dayUnix."/active.data";
        return self::getData($file);
    }

    /**
     * @param $name
     * @param $ip
     */
    public function updateMatches($name,$ip){
        $file =$this->activeDir."/robot.data";
        $data = self::getData($file);
        if(isset($data[$ip])){
            $arr_number = isset( $data[$ip]["number"])? ($data[$ip]["number"]+1) : 1;
            $arr_name = (isset($data[$ip]["name"]) and !empty($data[$ip]["name"])) ?$data[$ip]["name"].",".$name :$name;
            $data[$ip] =[
                "number"=>$arr_number,
                'name'=>$arr_name
            ];
        }else{
            $data[$ip]['number'] =1;
            $data[$ip]["name"]=$name;
        }
        self::saveData($file,$data);
    }

    /**
     * 统计来路信息
     * @param $referer
     * @param $ip
     */
    public function updateReferer($referer,$ip){
        $file =$this->activeDir."/referer.data";
        $data = self::getData($file);
        $data[time()]=["referer"=>$referer,$ip];
        self::saveData($file,$data);
    }

    /**
     * 获取来路信息
     * @param $dayUnix
     * @return array|mixed
     */
    public function getReferers($dayUnix){
        if(empty($dayUnix)){
            $dayUnix = self::getDayUnix();
        }
        $file = $this->path."/visits/". $dayUnix."/referer.data";
        return self::getData($file);
    }


    /**
     * 获取近几天访问量
     * @param $dayNumber
     */
    public function visits($dayNumber=7){
        $day = self::getDayUnix();
        $res =[];
        for($i=$dayNumber;$i>=0;$i--){
            $tmp_day = $day- ($i-1) * 24*60*60;
            $file= $this->path."/visits/". $tmp_day."/records.data";
            if(file_exists( $file)){
                $res[$tmp_day]= count( self::getData($file));
            }
        }
        return $res;
    }

    /**
     * 按不同浏览器统计访问量
     * @param $dayNumber
     */
    public function visitsByBrowsers($dayNumber=7){
        $visits = [];
        $day = self::getDayUnix();
        for($i=$dayNumber;$i>=0;$i--){
            $tmp_day = $day- ($i-1) * 24*60*60;
            $file = $this->path."/visits/". $tmp_day."/browser.data";
            if(file_exists( $file)){
                $day_data= self::getData($file);
                $visits = array_sum_by_key($visits,$day_data);
            }
        }

        $results =[];

        foreach ($visits as $key =>$visit){
            $results[] =[
                "value" => $visit,
                "color" => Color::randHex(),
                "highlight" => Color::randHex(),
                "label" =>Yii::t('app',$key)
            ];
        }
        return $results;
    }

    /**
     * 获取不同地区的访问两
     * @param int $dayNumber
     * @return array|void
     */
    public function JvectormapVisitors($dayNumber=7){
        $day = self::getDayUnix();
        //$res =["US" => 398]
        $res =[];
        for($i=$dayNumber;$i>=0;$i--){
            $tmp_day = $day- ($i-1) * 24*60*60;
            $file= $this->path."/visits/". $tmp_day."/records.data";
            $tmp_data = self::getData($file);
            $common = array_column($tmp_data,"country");
            if(!empty($tmp_data) and !empty($common)){
                try{
                    $res = array_sum_by_key($res,array_count_values($common));
                }catch (Exception $exception){
                    logObject(debug_backtrace());
                }

            }
        }
        return $res;
    }

    public function JvectormapMarkers($dayNumber=7,$country="all"){
        $day = self::getDayUnix();
        //$results = [["latLng" => [41.90, 12.45], "name" => 'Vatican City'],];
        $res =[];
        for($i=$dayNumber;$i>=0;$i--){
            $tmp_day = $day- ($i-1) * 24*60*60;
            $file= $this->path."/visits/". $tmp_day."/records.data";
            $tmp_data = self::getData($file);
            foreach ($tmp_data as $row){
                if($country =="all" ){
                    $res[$row["ip"]]   =["name"=>$row['city'],"latLng"=>$row['loc']];
                }elseif (isset($row['country']) and  !empty($country)){
                    if($row['country']==$country){
                        $res[$row["ip"]]   =["name"=>$row['city'],"latLng"=>$row['loc']];
                    }
                }
            }
        }
        $results =[];
        foreach ($res as $re){
            $results[]=["latLng" => explode(",",$re["latLng"]), "name" => Yii::t("city",$re["name"]) ];
        }
        return  $results;
    }

}