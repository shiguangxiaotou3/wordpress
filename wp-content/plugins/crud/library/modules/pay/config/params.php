<?php

$siteurl = trim( get_option('siteurl'),"/");


return [
    "menus" => [
        [
            "parent_slug" => "index",
            "page_title" => "支付",
            "menu_title" => "支付",
            "menu_slug" => "pay/index",
        ],
        [
            "parent_slug" => "pay/index",
            "page_title" => "阿里支付",
            "menu_title" => "阿里支付",
            "menu_slug" => "pay/index/alibaba",
        ],
        [
            "parent_slug" => "pay/index",
            "page_title" => "微信支付",
            "menu_title" => "微信支付",
            "menu_slug" => "pay/index/wechat",
        ],
        [
            "parent_slug" => "pay/index",
            "page_title" => "测试",
            "menu_title" => "测试",
            "menu_slug" => "pay/index/test",
        ],
        //remit
        [
            "parent_slug" => "pay/index",
            "page_title" => "转账到支付宝",
            "menu_title" => "测试",
            "menu_slug" => "pay/index/remit",
        ],
        //order
        [
            "parent_slug" => "pay/index",
            "page_title" => "订单表",
            "menu_title" => "测试",
            "menu_slug" => "pay/index/order",
        ],
        [
            "parent_slug" => "pay/index",
            "page_title" => "提现申请",
            "menu_title" => "提现申请",
            "menu_slug" => "pay/index/reflect",
        ],

    ],
    'settings' => [
        "alipay" => [
            'option_group' => 'crud_group',
            'page' => 'pay/index/alibaba',
            'section_id' => 'alipay',
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
                        "description" => "<hr style='width: 100%;' />",
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
                            "class" => "large-text code",
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
                            "class" => "large-text code",
                        ]
                    ],
                ],
                // 异步通知
                [
                    'id' => 'notifyUrl',
                    "title" => "默认异步通知",
                    'args' => [
                        "tag" => "text",
                        "description" => "支付完成后的异步通知url<code style='color: red'>POST</code>",
                        "defaultValue" => $siteurl ."/wp-json/crud/api/pay",
                        'options' => [
                            "class" => "large-text code",
                        ]
                    ],
                ],
                // 同步跳转
                [
                    'id' => 'returnUrl',
                    "title" => '默认同步跳转',
                    'args' => [
                        "tag" => "text",
                        "description" => "支付完成跳转的url<code style='color: red'>GET</code>",
                        "defaultValue" => $siteurl ."/crud/index/pay",
                        'options' => [
                            "class" => "large-text code",
                            "placeholder" => $siteurl ."/crud/index/pay",
                        ],
                    ],
                ],
                // 授权回调地址
                [
                    'id' => 'authorizationCallbackUil',
                    "title" => '授权回调地址',
                    'args' => [
                        "tag" => "text",
                        "description" => "对称加密<hr style='width: 100%;' />",
                        "defaultValue" => "https://www.shiguangxiaotou.com",
                        'options' => [
                            "class" => "large-text code",
                            "placeholder" => "https://www.shiguangxiaotou.com",
                        ],
                    ],
                ],
                /******** 加密选项 ***********/
                // 接口加密方式
                [
                    'id' => 'encryptType',
                    "title" => "接口加密模式",
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
                // 接口签名算法
                [
                    'id' => 'signType',
                    "title" => "接口签名算法",
                    'args' => [
                        "tag" => "dropDownList",
                        "items" => [
                            'RSA2' => 'RSA2',
                            'SM2' => 'SM2'
                        ],
                        "defaultValue" => 'RSA2',
                        'options' => [
                            "class" => "regular-text code"
                        ]
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
                        "defaultValue" => "@palKey/alipay/contentSecretKey_AES.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "/contentSecretKey_AES.txt",
                        ],
                    ],
                ],
                /******** 公钥模式 ***********/
                // 应用私钥
                [
                    'id' => 'appPrivateKey',
                    "title" => "应用私钥路径",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code><code style='color: red'>证书模式</code>",
                        "defaultValue" => "@palKey/alipay/appPrivateKey_RSA2048.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/appPrivateKey_RSA2048.txt",
                        ],
                    ],
                ],
                // 应用公钥
                [
                    'id' => 'appPublicKey',
                    "title" => "应用公钥路径",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code><code style='color: red'>证书模式</code>",
                        "defaultValue" => "@palKey/alipay/appPublicKey_RSA2048.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/appPublicKey_RSA2048.txt",
                        ],
                    ],
                ],
                // 支付宝公钥
                [
                    'id' => 'alipayPublicKey',
                    "title" => "支付宝公钥路径",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: rebeccapurple'>公钥模式</code>",
                        "defaultValue" => "@palKey/alipay/alipayPublicKey_RSA2.txt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/alipayPublicKey_RSA2.txt",
                        ],
                    ],
                ],
                /******** 证书模式 ***********/
                // 应用公钥证书
                [
                    'id' => 'appPublicCert',
                    "title" => "应用公钥证书路径",
                    'args' => [
                        "tag" => "text",
                        "description" => "<code style='color: red'>证书模式</code>",
                        "defaultValue" => "@palKey/alipay/appPublicCert.crt",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/appPublicCert.crt",
                        ],
                    ],
                ],
                // 支付宝公钥证书
                [
                    'id' => 'alipayPublicCert',
                    "title" => "支付宝公钥证书路径",
                    'args' => [
                        "tag" => "text",

                        "defaultValue" => "@palKey/alipay/alipayPublicCert.crt",
                        "description" => "<code style='color: red'>证书模式</code>",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/alipayPublicCert.crt",
                        ],
                    ],
                ],
                // 支付宝根证书
                [
                    'id' => 'alipayRootCert',
                    "title" => "支付宝根证书路径",

                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "@palKey/alipay/alipayRootCert.crt",
                        "description" => "<code style='color: red'>证书模式</code>",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => "@palKey/alipay/alipayRootCert.crt",
                        ],
                    ],
                ],

            ]
        ],
        "wechatpay" => [
            'option_group' => 'crud_group',
            'page' => 'pay/index/wechat',
            'section_id' => 'wechatpay',
            "section_description" => '微信支付配置',
            'fields' => [
                [
                    'id' => 'appId',
                    "title" => "App Id",
                    'args' => [
                        "tag" => "text",
                        "description" =>'「APP ID」',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'merchantId',
                    "title" => "merchantId",
                    'args' => [
                        "tag" => "text",
                        "description" =>'「商户号」<br>例如:<code style="color: red">1639392133</code>',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'apiV3Key',
                    "title" => 'Api V3 Key',
                    'args' => [
                        "tag" =>  "text",
                        "description" =>'Api V3 Key',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                // 异步通知
                [
                    'id' => 'notifyUrl',
                    "title" => "默认异步通知",
                    'args' => [
                        "tag" => "text",
                        "description" => "支付完成后的异步通知url<code style='color: red'>POST</code>",
                        "defaultValue" => $siteurl ."/wp-json/crud/api/pay",
                        'options' => [
                            "class" => "large-text code",
                        ]
                    ],
                ],
                // 同步跳转
                [
                    'id' => 'returnUrl',
                    "title" => '默认同步跳转',
                    'args' => [
                        "tag" => "text",
                        "description" => "支付完成跳转的url<code style='color: red'>GET</code>",
                        "defaultValue" => $siteurl ."/crud/index/pay",
                        'options' => [
                            "class" => "large-text code",
                            "placeholder" => $siteurl ."/crud/index/pay",
                        ],
                    ],
                ],
                [
                    'id' => 'merchantCertificateSerial',
                    "title" => "merchant Certificate Serial",
                    'args' => [
                        "tag" =>  "text",
                        "defaultValue"=>'',
                        "description"=>'「商户API证书」的「证书序列号」<br>例如:<code style="color: red">3775B6A45ACD588826D15E583A95F5DD********</code>',
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'merchantPrivateKeyFilePath',
                    "title" => "merchant PrivateKey FilePath",
                    'args' => [
                        "tag" => "text",
                        "description"=>'「商户API私钥」<br>例如:<code style="color: red">@palKey/wechat/apiclient_key.pem</code>',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'merchantPublicKeyFilePath',
                    "title" => "merchant PublicKey FilePath",
                    'args' => [
                        "tag" => "text",
                        "description"=>'「商户API公钥」<br>例如:<code style="color: red">@palKey/wechat/apiclient_cert.pem</code>',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'platformCertificateFilePath',
                    "title" => "platform Certificate FilePath",
                    'args' => [
                        "tag" => "text",
                        'afterHtml'=>'<input type="button"  class="button " title="微信支付平台证书"  id="platformCertificateFilePath" value="微信支付平台证书" >',
                        "description"=> '「微信支付平台证书」<br>例如:<code style="color: red">额外需要Api V3 Key</code>',
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
    ],
];