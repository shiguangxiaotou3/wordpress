<?php
Yii::setAlias('@crud', dirname(dirname(__DIR__ )). '/');
Yii::setAlias('@vendor', dirname(dirname(__DIR__))."/vendor" );
Yii::setAlias('@backend', dirname(dirname(__DIR__ )). '/backend');
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@common',dirname(__DIR__));
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('@library', dirname(dirname(__DIR__) ). '/library');
Yii::setAlias('@test', dirname(dirname(__DIR__) ). '/test');
Yii::setAlias('@bower' , dirname(dirname(__DIR__))."/vendor/bower-asset" );
Yii::setAlias('@npm', dirname(dirname(__DIR__))."/vendor/npm-asset" );


/**
 * 由于插件的控制台模块是一个单独的模块，
 * 不想加载多余的wordpress文件,但是有需要操作数据库,
 * 所以只能通过读写文件的方式(wp-config.php)，获取数据库dsn
 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH',  dirname(dirname( dirname(dirname(dirname(__DIR__ ))))) . '/' );
}

/**
 * 请确保debug.php已被加载
 * 并在common/config/main-local.php 加载前没执行
 */
if(defined( 'ABSPATH' ) and !defined("DB_NAME")){
    $config_str = file_get_contents(ABSPATH . "wp-config.php");
    define("DB_NAME", getDefineValueByName($config_str, "DB_NAME"));
    define('DB_USER', getDefineValueByName($config_str, 'DB_USER'));
    define("DB_PASSWORD", getDefineValueByName($config_str, "DB_PASSWORD"));
    define('DB_HOST', getDefineValueByName($config_str, 'DB_HOST'));
    define('DB_CHARSET', getDefineValueByName($config_str, 'DB_CHARSET'));
    define('DB_COLLATE', getDefineValueByName($config_str, "DB_COLLATE"));
    define("DB_TABLE_PREFIX", getVarValueByVarName($config_str, "table_prefix"));
}

/**
 * cli 模式 get_option
 */
if(!function_exists("get_option")){
    function get_option($option, $default = false){
        $dsn="mysql:host=".DB_HOST.";dbname=".DB_NAME;
        $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
        $results = $conn->query("SELECT * FROM wp_options WHERE option_name ='".$option."'");
        $value = $default;
        //serialize(mixed
        foreach ($results as $row){
            if(isset($row["option_value"])){
                $value = $row["option_value"];
                unset($conn);
                break;
            }

        }
        unset($conn);
        return is_serialized($value) ? unserialize($value) : $value;
    }
}



