<?php


/**
 * 我的测试公共函数
 *
 */
define('UNIT', __DIR__);
defined('DEBUG_FILE') or define('DEBUG_FILE', __DIR__ . "/a.txt");
defined('DEBUG_JSON') or define('DEBUG_JSON', __DIR__ . "/a.json");

if (!function_exists('dumpInfo')) {
    /**
     * @param $conf
     */
    function dumpInfo($conf)
    {
        $path = $conf[0]['file'];
        $line = $conf[0]['line'];
        unset($conf);
        $str = '// +----------------------------------------------------------------------' . "\r\n";
        $str .= '// | 调用文件: ' . $path . "\r\n";
        $str .= '// +----------------------------------------------------------------------' . "\r\n";
        $str .= '// | 调用行数: ' . "第" . $line . "行被调用\r\n";
        $str .= '// +----------------------------------------------------------------------' . "\r\n";
        $str .= '// | 调用时间: ' . date('Y-m-d h:m:s', time()) . "\r\n";
        $str .= '// +----------------------------------------------------------------------' . "\r\n";

        file_put_contents(DEBUG_FILE, "\r\n" . $str, FILE_APPEND);
    }
}

if (!function_exists('logStr')) {
    /**
     * @param $str
     * @param string $type
     */
    function logStr($str, $type = "txt")
    {
//    dumpInfo(debug_backtrace());
        if ($type == "txt") {
            file_put_contents(DEBUG_FILE, $str . "\r\n", FILE_APPEND);
        } else {
            file_put_contents(DEBUG_JSON, $str . "\r\n", FILE_APPEND);
        }

    }
}

if (!function_exists('logObject')) {
    /**
     * @param $obj
     * @param string $file
     * @param int $flags
     */
    function logObject($obj, $file = DEBUG_FILE, $flags = FILE_APPEND)
    {
        $conf = debug_backtrace();
        dumpInfo($conf);
        if (empty($flags)) {
            file_put_contents($file, print_r($obj, true) . "\r\n");
        } else {
            file_put_contents($file, print_r($obj, true) . "\r\n", $flags);
        }

    }
}

if (!function_exists('dump')) {
    function dump($res)
    {
        echo "<pre>";
        print_r($res);
        echo "</pre>";
    }
}

if (!function_exists('my_debug_backtrace')) {
    /**
     * @param int $flags
     */
    function my_debug_backtrace($flags = FILE_APPEND)
    {
        $arr = debug_backtrace();
        $str = print_r($arr, true);
        file_put_contents(DEBUG_FILE, str_replace("xxxx", "", $str), $flags);
    }
}

if (!function_exists('logHook')) {
    /**
     * 记录请求执行的钩子名称
     * @param $hook_name
     */
    function logHook($hook_name)
    {
        $time = time() . ".txt";
        file_put_contents(CRUD_DIR . "/library/hook/" . $time, $hook_name . "\r\n", FILE_APPEND);
    }
}

if (!function_exists('testDebug')) {
    /**
     * 接口测试
     * 脚本退出时执行回调函数
     * @param $title
     * @param array $data
     * @param string $email
     */
    function testDebug($title, $data = [], $email = "757402123@qq.com")
    {
        if (YII_DEBUG) {
            if (function_exists('wp_mail')) {
                register_shutdown_function(function () use ($email, $title, $data) {
                    wp_mail($email, $title, print_r($data, true));
                });
            }
        }

    }
}
