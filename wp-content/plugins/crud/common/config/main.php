<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        "crawlers"=>[
            'class'=>"crud\components\Crawlers"
        ],
        //翻译组件
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
                'wp' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@library/messages/wp',
                    'fileMap' => [
                        'wp' => 'wp.php',
                        'wp/error' => 'error.php',
                    ],
                ],
                'console' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@library/messages/console',
                    'fileMap' => [
                        'console' => 'console.php',
                        'console/error' => 'error.php',
                    ],
                ],
                'city' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@library/messages/city',
                    'fileMap' => [
                        'city' => 'city.php',
                        'city/error' => 'error.php',
                    ],
                ],
                'ads' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@library/messages/ads',
                    'fileMap' => [
                        'country' => 'ads.php',
                        'country/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'wechat' => [
            'class' => 'crud\modules\wechat\Wechat',
        ],
    ],
];

