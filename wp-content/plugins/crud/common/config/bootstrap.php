<?php
Yii::setAlias('@uploads',dirname(__DIR__,4)."/uploads" );
Yii::setAlias('@crud', dirname(dirname(__DIR__ )).'/library');
Yii::setAlias('@vendor', dirname(dirname(__DIR__))."/vendor" );
Yii::setAlias('@backend', dirname(dirname(__DIR__ )). '/backend');
Yii::setAlias('@common',dirname(__DIR__));
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
//Yii::setAlias('@library', dirname(dirname(__DIR__) ). '/library');
Yii::setAlias('@bower' , dirname(dirname(__DIR__))."/vendor/bower-asset" );
Yii::setAlias('@npm', dirname(dirname(__DIR__))."/vendor/npm-asset" );
Yii::setAlias('@palKey', dirname(__DIR__,2)."/library/modules/pay/components/key");

defined("CRUD_DIR") or define("CRUD_DIR" ,dirname(dirname(__DIR__)));
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

/**
 * 由于插件的控制台模块是一个单独的模块，
 * 不想加载多余的wordpress文件,但是又需要操作数据库,
 * 所以只能通过读写文件的方式(wp-config.php)，获取数据库dsn
 */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH',  dirname(__DIR__ ,5) . '/' );
}

/**
 * 请确保debug.php已被加载
 * 并在common/config/bootstrap.php 加载前没执行
 */
$config_str = file_get_contents(ABSPATH . "wp-config.php");
defined("DB_NAME") or define('DB_NAME', getDefineValueByName($config_str, "DB_NAME"));
defined('DB_USER') or define('DB_USER', getDefineValueByName($config_str, 'DB_USER'));
defined("DB_PASSWORD") or define("DB_PASSWORD", getDefineValueByName($config_str, "DB_PASSWORD"));
defined('DB_HOST') or define('DB_HOST', getDefineValueByName($config_str, 'DB_HOST'));
defined('DB_CHARSET') or define('DB_CHARSET', getDefineValueByName($config_str, 'DB_CHARSET'));
defined('DB_COLLATE') or define('DB_COLLATE', getDefineValueByName($config_str, "DB_COLLATE"));
defined('DB_TABLE_PREFIX') or define('DB_TABLE_PREFIX', getVarValueByVarName($config_str, "table_prefix"));
unset($config_str);

/**
 * cli模式get_option
 */
if(!function_exists("get_option")){
    if( defined("DB_NAME") and
        defined('DB_USER') and
        defined("DB_PASSWORD") and
        defined('DB_HOST') and
        defined('DB_CHARSET') and
        defined('DB_TABLE_PREFIX')){
        function get_option($option, $default = false){
            $dsn="mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
            $conn = new PDO($dsn,DB_USER,DB_PASSWORD);
            $results = $conn->query("SELECT * FROM ".DB_TABLE_PREFIX."options WHERE option_name ='".$option."'");
            $value = $default;
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
    }else{
        echo "数据库链接常量为定义".PHP_EOL;
        die();
    }

}



