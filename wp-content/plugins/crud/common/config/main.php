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
        "assetManager"=>[
            // 定义资源包发布目录， you project/wp-content/uploads/assets
            'class' => 'yii\web\AssetManager',
            "basePath" => '@uploads/assets',
            "baseUrl" => '/wp-content/uploads/assets',
        ],
        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        //翻译组件
        'i18n' => [
            'translations' => [
//                'app' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@common/messages',
//                    'fileMap' => [
//                        'app' => 'app.php',
//                        'app/error' => 'error.php',
//                    ],
//                ],
//                'wp' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@crud/messages/wp',
//                    'fileMap' => [
//                        'wp' => 'wp.php',
//                        'wp/error' => 'error.php',
//                    ],
//                ],
                'pay' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@pay/messages/pay',
                    'fileMap' => [
                        'pay' => 'pay.php',
                        'pay/error' => 'error.php',
                    ],
                ],
                'market' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@market/messages/market',
                    'fileMap' => [
                        'market' => 'market.php',
                        'market/error' => 'error.php',
                    ],
                ],
                'console' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@crud/messages/console',
                    'fileMap' => [
                        'console' => 'console.php',
                        'console/error' => 'error.php',
                    ],
                ],
                'city' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@crud/messages/city',
                    'fileMap' => [
                        'city' => 'city.php',
                        'city/error' => 'error.php',
                    ],
                ],
                'ads' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@crud/messages/ads',
                    'fileMap' => [
                        'country' => 'ads.php',
                        'country/error' => 'error.php',
                    ],
                ],
                'wechat' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@wechat/messages/wechat',
                    'fileMap' => [
                        'wechat' => 'wechat.php',
                        'wechat/error' => 'error.php',
                    ],
                ],
                'movie' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@crud/messages/movie',
                    'fileMap' => [
                        'movie' => 'movie.php',
                        'movie/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],

];

