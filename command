#!/usr/bin/env php
<?php

$config = require "wp-content/plugins/crud/console/web/App.php";
$application = new yii\console\Application($config);
// 控制台汉化包装类
$application->controllerMap['help'] = 'crud\library\controllers\HelpController';
$exitCode = $application->run();
exit($exitCode);