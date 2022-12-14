<?php

return [
    "menus" => [
        [
            "parent_slug" => "index",
            "page_title" => "支付",
            "menu_title" => "支付",
            "menu_slug" => "alipay/index",
        ],
        [
            "parent_slug" => "alipay/index",
            "page_title" => "阿里支付",
            "menu_title" => "阿里支付",
            "menu_slug" => "alipay/index/alibaba",
        ],

    ],
    'settings' => [
        "alibaba" => [
            'option_group' => 'crud_group',
            'page' => 'alipay/index/alibaba',
            'section_id' => 'alibaba',
            "section_description" => '支付宝配置',
            'fields' => [
                // appID
                [
                    'id' => 'appId',
                    "title" => "应用Id",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                // 应用名称
                [
                    'id' => 'appName',
                    "title" => "应用名称",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                // 绑定的商家账号(PID)
                [
                    'id' => 'pid',
                    "title" => "绑定的商家账号(PID)",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                // 支付宝网关地址
                [
                    'id' => 'alipayUli',
                    "title" => "支付宝网关地址",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "https://openapi.alipaydev.com/gateway.do",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => 'https://openapi.alipaydev.com/gateway.do',
                        ]
                    ],
                ],
                // 应用网关地址
                [
                    'id' => 'gateway',
                    "title" => "应用网关地址",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "https://www.shiguangxiaotou.com",
                        'options' => [
                            "class" => "regular-text code",
                        ]
                    ],
                ],
                // 授权回调地址
                [
                    'id' => 'authorizationCallbackUil',
                    "title" => '授权回调地址',
                    "description" => "对称加密<hr style='width: 100%;' />",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "https://www.shiguangxiaotou.com",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "https://www.shiguangxiaotou.com",
                        ],
                    ],
                ],
                /******** 公钥模式 ***********/
                // 接口加密方式
                [
                    'id' => 'encryptType',
                    "title" => "接口加密方式",
                    'args' => [
                        "tag" => "dropDownList",
                        "items" => [
                            '1' => '公钥模式',
                            '0' => '证书模式'
                        ],
                        "defaultValue" => 1,
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                // 支付宝公钥
                [
                    'id' => 'alipayPublicKey',
                    "title" => "支付宝公钥",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code>",
                        "defaultValue" => "/key/alipayPublicKey_RSA2.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/key/alipayPublicKey_RSA2.txt",
                        ],
                    ],
                ],
                // app公钥
                [
                    'id' => 'appPublicKey',
                    "title" => "应用公钥",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code>",
                        "defaultValue" => "/key/appPublicKey_RSA2048.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/key/appPublicKey_RSA2048.txt",
                        ],
                    ],
                ],
                // app私钥
                [
                    'id' => 'appPrivateKey',
                    "title" => "应用私钥",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code>",
                        "defaultValue" => "/key/appPrivateKey_RSA2048.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/key/appPrivateKey_RSA2048.txt",
                        ],
                    ],
                ],
                /******** 证书模式 ***********/
                // app公钥证书
                [
                    'id' => 'appPublicCert',
                    "title" => "应用公钥证书",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: red'>证书模式</code>",
                        "defaultValue" => "/certificate/appPublicCert.crt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/certificate/appPublicCert.crt",
                        ],
                    ],
                ],
                // app证书私钥
                [
                    'id' => 'appPrivateCertKey',
                    "title" => "应用证书私钥",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: red'>证书模式</code>",
                        "defaultValue" => "/certificate/appPublicCertKey.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/certificate/appPublicCertKey.txt",
                        ],
                    ],
                ],
                // 支付宝公钥证书
                [
                    'id' => 'alipayPublicCert',
                    "title" => "支付宝公钥证书",
                    'args' => [
                        "tag" => "text",

                        "defaultValue" => "/certificate/alipayPublicCert.crt",
                        "description" => "<code style='color: red'>证书模式</code>",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/certificate/alipayPublicCert.crt",
                        ],
                    ],
                ],
                // 支付宝根证书
                [
                    'id' => 'alipayRootCert',
                    "title" => "支付宝根证书",

                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "/certificate/alipayRootCert.crt",
                        "description" => "<code style='color: red'>证书模式</code>",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/certificate/alipayRootCert.crt",
                        ],
                    ],
                ],
                /******** 接口内容加密 ***********/
                // 接口内容加密方式
                [
                    'id' => 'contentEncryptType',
                    "title" => "接口内容加密方式",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => 0,
                        "description" => "默认明文,开启后加密",
                        "items" => [
                            '0' => '明文模式',
                            '1' => '加密模式'
                        ],
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                // 接口内容加解密密钥
                [
                    'id' => 'contentSecretKey',
                    "title" => "接口内容加解密密钥",
                    "description" => "对称加密",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "/key/contentSecretKey_AES.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/key/contentSecretKey_AES.txt",
                        ],
                    ],
                ],
            ]
        ],
    ],
];