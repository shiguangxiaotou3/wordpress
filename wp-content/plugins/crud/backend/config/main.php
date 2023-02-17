<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id' => 'backend',
    'name' => '时光小偷的博客',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => "index",
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'components' => [
        // 不在需要layout,视图布局文件由wordpress决定
        'controller'=>[
            'class'=>" yii\web\Controller",
            'layout'=>false,
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
                'text/xml' => 'crud\components\XmlRequestParser',
                'application/xml' => 'crud\components\XmlRequestParser',
            ],
        ],
        // 重写response
//        'response'=>[
//            'class'=>"crud\components\Response"
//        ],
        "cache" => [
            'class' => "yii\caching\FileCache",
            "cachePath" => "@runtime/cache"
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        "urlManager" => [
            "routeParam"=>"page",
            "rules" => [
                "<controller:[\w-]+>/<action:[\w-]+>/<id:\d+>"=>"<controller>/<action>",
                "<controller:[\w-]+>/<action:[\w-]+>"=>"<controller>/<action>",
            ]
        ],

        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
    ],
    'params' => $params,
];


