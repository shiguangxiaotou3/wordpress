<?php

/**
 * crud插件公共函数
 */

/**
 * 启用插件
 */
function crud_activate(){
    flush_rewrite_rules();
}

/**
 * 禁用插件
 */
function crud_deActivate(){
    flush_rewrite_rules();
}

/**
 * 获取函数的的形参名称
 * @param $functionName
 * @return false|array
 */
function getFunctionArgs($functionName){
    if (function_exists($functionName)) {
        try {
            $fun = new  ReflectionFunction($functionName);
        } catch (ReflectionException $e) {
            return false;
        }
        $paramsName = [];
        foreach ($fun->getParameters() as $parameter) {
            $paramsName[] = $parameter->name;
        }
        return $paramsName;
    }
}

/**
 * 获取一个类的某个方法的形参名称
 * @param $className
 * @param $methodName
 * @return false|array
 */
function getMethodArgs($className, $methodName){
    try {
        $ref = new ReflectionMethod($className, $methodName);
    } catch (ReflectionException $e) {
        return false;
    }
    $paramsName = [];
    foreach ($ref->getParameters() as $param) {
        $paramsName[] = $param->name;
    }
    return $paramsName;
}

/**
 * 获取类的方法和形参名称
 * @param $className
 * @return array
 */
function getClassInfo($className){
    $results =[];
    $methods = get_class_methods($className);
    if(!empty($methods)){
        foreach ($methods as $method){
            $results[$method] = getMethodArgs($className,$method);
        }
    }
    return $results;
}

/**
 * 兼容对象和函数的写法
 * @return array|mixed
 */
function getParams(){
    $backtrace = debug_backtrace()[1];
    $functionName = $backtrace['function'];
    if (isset($backtrace["class"])) {
        $paramsNames = getMethodArgs($backtrace["class"], $functionName);
    } else {
        $paramsNames = getFunctionArgs($functionName);
    }
    return $paramsNames;
    return ($paramsNames and !empty($paramsNames))
        ? array_combine($paramsNames, $backtrace["args"])
        : $backtrace["args"];
}

/**
 * @param $object
 * @param $data
 */
function assignment($object,$data){

}

/**
 * 通过常量名称,读取php文件中定义的常量值
 * @param string $str 文件的字符串
 * @param string $name 常量名称
 * @return false|mixed|string|string[]
 */
function getDefineValueByName($str, $name)
{
    $results = "";
    if (preg_match("/define\s*\(\s*(\"|\')" .
        $name . "(\"|\')\s*\,\s*(\"|\')\S*(\"|\')\s*\)\s*\;/",
        $str, $value)) {
        if (isset($value[0]) and !empty($value[0])) {
            $results = $value[0];
            $results = preg_replace(
                "/define\s*\(\s*(\"|\')" .
                $name . "(\"|\')\s*\,\s*(\"|\')/",
                "",$results);
            $results = preg_replace("/(\"|\')\s*\)\s*\;/",
                "",$results);
            return $results;
        }
    }
    return "";
}

/**
 * 通过变量名称,读取php文件中定义的变量值
 * 只能匹配字符串
 * @param $str
 * @param $name
 * @return mixed|string|string[]
 */
function getVarValueByVarName($str, $name)
{
    $results = "";
    if (preg_match(
        '/\$'.$name.'\s*\=\s*(\'|\")\S*(\'|\")\s*\;/',
        $str, $value)) {
        if (isset($value[0]) and !empty($value[0])) {
            $results = $value[0];
            $results = preg_replace(
                '/\$'.$name.'\s*\=\s*(\'|\")/',"",$results);
            $results = preg_replace("/(\'|\")\s*\;/",
                "",$results);
            return $results;
        }
    }
    return "";
}

/**
 * 驼峰名称转换:WpTable=>wp_table
 * wpTable=>wp_table
 * @param string $str
 * @param string $interval
 * @return string
 */
function toUnderScore($str, $interval = "_")
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) use ($interval) {
        return $interval . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/' . $interval . '{2,}/', $interval, $dstr), $interval);
}

/**
 * 驼峰名称转换
 * 将 wp_table=>WpTable或wpTable
 * @param string $str
 * @param bool $flags
 * @param string $interval
 * @return string|string[]
 */
function toScoreUnder($str, $flags = true, $interval = "_")
{
    $results = str_replace($interval, " ", $str);
    // 大驼峰
    $results = str_replace(' ', "", ucwords($results));
    return $flags ? $results : lcfirst($results);

}

/**
 * 数组根据键名称相加
 */
function array_sum_by_key(){
    $args = func_get_args();
    $keys =[];
    foreach ($args as $arg){
        $keys=array_merge($keys,array_keys($arg));
    }
    $keys =array_unique( $keys);
    $results =[];
    foreach ($keys as $key){
        $results[$key]=0;
        foreach ($args as $arg){
            if(isset($arg[$key]) and is_numeric($arg[$key])){
                $results[$key] += $arg[$key];
            }
        }
    }
   return $results;

}

/**
 * 判断字符串是否为序列号数据
 */
if(!function_exists("is_serialized")){
    /**
     * 判断是否为序列号数据
     * @param $data
     * @return bool
     */
    function is_serialized( $data ) {
        $data = trim( $data );
        if ( 'N;' == $data )
            return true;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
            return false;
        switch ( $badions[1] ) {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                    return true;
                break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                    return true;
                break;
        }
        return false;
    }
}

/**
 * 构造写入数据
 * @param $str
 * @param $array
 * @param int $space
 */
function ConfigToStr(&$str, $array, $space = 0){
    $s ='' ;
    for($i=0; $i<$space*4;$i++){
        $s .= " ";
    }
    foreach($array as $k=>$item){
        if(is_array($item)){
            $str .= "$s'$k' => [\r\n";
            $str .= ConfigToStr($str, $item, $space+1);
            $str .= "$s],\r\n";
        }else{
            $k = str_replace('\'','\\\'',$k);
            $item = str_replace('\'','\\\'',$item);
            $str .= "$s'$k' => '$item',\r\n";
        }
    }
}

/**
 * 构造写入字符串,并写入文件中
 * @param $filePath
 * @param $config
 * @return false|int
 */
function writeConfig($filePath, $config){
    if(file_exists($filePath)){
        unlink($filePath);
    }
    $str = "<?php\r\nreturn [\r\n";  // 拼接数组字符串-开头
    $str .= ConfigToStr($str, $config,1);  // 拼接数组字符串-中间
    $str .= "];";  //
    return file_put_contents($filePath, $str,FILE_APPEND);
}

/**
 * 构造写入字符串,并写入文件中
 * @param $filePath
 * @param $config
 * @return false|int
 */
function upDateConfig($filePath, $config){
    try {
        $tmp_config = require_once $filePath;
    }catch (Exception$exception ){
        $tmp_config = [];
    }
    $save_config = array_merge($tmp_config,$config);
    if($tmp_config != $save_config){
        $str = "<?php\r\nreturn [\r\n";  // 拼接数组字符串-开头
        $str .= ConfigToStr($str,  $save_config,1);  // 拼接数组字符串-中间
        $str .= "];";  //
        return file_put_contents($filePath, $str);
    }

}

/**
 * 替换中文符号
 * @param $str
 * @return string|string[]
 */
function replaceSymbol($str){
    $config =[
        "。"=>".",
        "（"=>"(",
        "）"=>")",
        "“"=>"\"",
        "”"=>"\"",
        "'"=>"\'",
        "？"=>"?"
    ];
    foreach ($config as $key =>$value){
        $str = str_replace($key,$value,$str);
    }
    return $str;
}

/**
 * 删除递归删除文件.DS_Store文件
 * @param $dir
 * @param string|array $file
 */
function deleteDsStore($dir, $deleteFile)
{
    $handle = opendir($dir);
    while (false !== ($file = readdir($handle))) {
        if ($file != '.' && $file != '..') {
            if(is_array($deleteFile)){
                if(in_array($file, $deleteFile)){
                    if (unlink($dir . "/" . $file)) {
                        echo $dir . "/" . $file . "\n";
                    }
                }
            }else{
                if (($file == $deleteFile) ) {
                    if (unlink($dir . "/" . $file)) {
                        echo $dir . "/" . $file . "\n";
                    }
                }
            }
            if (is_dir($dir . "/" . $file)) {
                deleteDsStore($dir . "/" . $file,$deleteFile);
            }
        }
    }
    closedir($handle);
}