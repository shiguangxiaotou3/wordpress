#!/usr/bin/env php
<?php

$config = require "wp-content/plugins/crud/console/web/App.php";
use yii\console\Application;
use yii\base\InvalidConfigException;

try {
    $application = new Application($config);
    // 控制台汉化包装类
    $application->controllerMap['help'] = 'crud\library\controllers\HelpController';
    $exitCode = $application->run();
    exit($exitCode);
} catch (InvalidConfigException $e) {
    exit($e->getMessage());
}
//php command   gii/model --ns=crud\\modules\\pay\\models --tableName=wp_order --modelClass=Order