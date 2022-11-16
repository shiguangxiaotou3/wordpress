<?php
use crud\models\Files;

/**
 * 非常建议在应用加载前调用yii的类,
 * 但是为了动态加载highlight/styles样式表没办法
 */
$files = Files::getCssFiles("@bower/highlight/styles");
if(!empty(  $files)){
    $styles =array_combine($files,$files);
}else{
    $styles =[];
}


return [
    "menus" => [
        // 首页
        [
            "page_title" => "Crud Plugins",
            "menu_title" => "Crud Plugins",
            "capability" => 'manage_options',
            "menu_slug" => "index",
            "icon_url" => 'dashicons-align-full-width'
        ],
        // 空白
        [
            "parent_slug" => "index",
            "page_title" => "Home",
            "menu_title" => "Home",
            "menu_slug" =>  "index",
        ],
        // 设置
        [
            "parent_slug" => "index",
            "page_title" => "设置",
            "menu_title" => "设置",
            "menu_slug" => "settings",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "设置",
            "menu_title" => "设置",
            "menu_slug" => "settings/index",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "Ip解析物理地址",
            "menu_title" => "Ip解析物理地址",
            "menu_slug" => "settings/ipinfo",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "SMTP服务",
            "menu_title" => "SMTP服务",
            "menu_slug" => "settings/mail",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "阿里云Dns解析",
            "menu_title" => "阿里云Dns解析",
            "menu_slug" => "settings/dns",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "Google 翻译api",
            "menu_title" => "Google 翻译api",
            "menu_slug" => "settings/translate",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "代码高亮",
            "menu_title" => "代码高亮",
            "menu_slug" => "settings/highlight",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "jvectormap SVG地图",
            "menu_title" => "jvectormap SVG地图",
            "menu_slug" => "settings/jvectormap",
        ],
        [
            "parent_slug" => "settings",
            "page_title" => "爬虫检测",
            "menu_title" => "爬虫检测",
            "menu_slug" => "settings/crawlers",
        ],
        // Bing广告api SDK
        [
            "parent_slug" =>  "index",
            "page_title" => "Bing 广告",
            "menu_title" => "Bing 广告",
            "menu_slug" => "ads",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "回调",
            "menu_title" => "回调",
            "menu_slug" => "ads/redirect-uri",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "回调",
            "menu_title" => "回调",
            "menu_slug" => "ads/redirect-uri",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "文档",
            "menu_title" => "文档",
            "menu_slug" => "ads/doc",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "Flows在线测试",
            "menu_title" => "Flows在线测试",
            "menu_slug" => "ads/flows",
        ],
        // 文档
        [
            "parent_slug" =>  "index",
            "page_title" => "Doc",
            "menu_title" => "Doc",
            "menu_slug" => "doc",
        ],
        [
            "parent_slug" => "doc",
            "page_title" => "Icons",
            "menu_title" => "Icons",
            "menu_slug" => "doc/icons",
        ],
        // 测试
        [
            "parent_slug" => "index",
            "page_title" => "Test",
            "menu_title" => "Test",
            "menu_slug" => "test",
        ],
        // 错误
        [
            "parent_slug" =>  "index",
            "page_title" => "Error",
            "menu_title" => "Error",
            "menu_slug" => "error",
        ],
        // 微信公众号
        [
            "parent_slug" =>  "index",
            "page_title" => "微信公众号",
            "menu_title" => "微信公众号",
            "menu_slug" => "subscription-service",
        ],
//        [
//            "parent_slug" =>  "index",
//            "page_title" => "Bing 广告",
//            "menu_title" => "Bing 广告",
//            "menu_slug" => "ads",
//        ],


    ],
    'settings' => [
        "switch" => [
            'option_group' => 'crud_group',
            'page' => 'settings',
            'section_id' => 'switch',
//            "section_description" => '启用组件后才回生效',
            'fields' => [
                [
                    "id" => "switch",
                    "title" => "服务",
                    'args' => [
                        "tag" => "switch",
                        "options" => [
                            "class" => "regular-text code"
                        ],
                        'switch' => [
                            ["checked" => 1, "description" => "ipInfo: ip地址解析物理地址", "options" => ["value" => "ipinfo"]],
                            ["checked" => 1, "description" => "mail: SMTP服务", "options" => ["value" => "mail"]],
                            ["checked" => 1, "description" => "jvectormap: SVG地图插件", "options" => ["value" => "jvectormap"]],
                            ["checked" => 1, "description" => "dns: 阿里dns解析API", "options" => ["value" => "dns"]],
                            ["checked" => 1, "description" => "translate: Google 翻译API", "options" => ["value" => "translate"]],
                            ["checked" => 1, "description" => "highlight: 代码高亮显示", "options" => ["value" => "highlight"]],
                            ["checked" => 1, "description" => '机器人/蜘蛛/爬虫', "options" => ["value" => "crawlers"]],
                        ],
                    ]
                ]
            ]
        ],
        'ipinfo' => [
            'option_group' => 'crud_group',
            'page' => 'settings/ipinfo',
            'section_id' => 'ipinfo',
            "section_description" => '通过ip地址解析物理地址',
            'fields' => [
                [
                    'id' => 'token',
                    "title" => "",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "获取token请前往:<a href='https://ipinfo.io/' target='_blank'>ipinfo.io</a>",
                        "options" => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ],
            'args' => [],
        ],
        'mail' => [
            'option_group' => 'crud_group',
            'page' => 'settings/mail',
            'section_id' => 'mail',
            "section_description" => 'SMTP服务设置',
            'fields' => [
                [
                    'id' => 'host',
                    "title" => "服务器地址",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "smtp服务器地址",
                        'options' => [
                            "placeholder" => 'smtp.qq.com',
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'port',
                    "title" => "端口号",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "465",
                        'options' => [
                            "placeholder" => "465",
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'encryption',
                    "title" => "加密方式",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "ssl",
                        "options" => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'username',
                    "title" => "用户名",
                    'args' => [
                        "tag" => "text",
//                        "defaultValue" => get_option("admin_email"),
                        "description" => "登录smtp服务的用户名",
                        'options' => [
                            "placeholder" => 'xxxx@qq.com',
                            "class" => "regular-text code"
                        ],

                    ],
                ],
                [
                    'id' => 'password',
                    "title" => "密码",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "登录smtp服务的密码",
                        'options' => [
                            "placeholder" => 'xxxx@qq.com',
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'blogname',
                    "title" => "发件人",
                    'args' => [
                        "tag" => "text",
                        'options' => [
                            "placeholder" => get_option("blogname"),
                            "class" => "regular-text code"
                        ],
//                        "defaultValue" => get_option("blogname"),
                    ],
                ],
            ],
            'args' => [],
        ],
        'dns' => [
            'option_group' => 'crud_group',
            'page' => 'settings/dns',
            'section_id' => 'dns',
            "section_description" => '阿里云域名管理',
            'fields' => [
                [
                    'id' => 'accessKeyId',
                    "title" => "accessKeyId",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'accessSecret',
                    "title" => "accessSecret",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "smtp服务器地址",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ],
            'args' => [],

        ],
        "translate" => [
            'option_group' => 'crud_group',
            'page' => 'settings/translate',
            'section_id' => 'translate',
            "section_description" => 'Google Translate',
            'fields' => [
                [
                    'id' => 'key',
                    "title" => "Cloud key",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "highlight" => [
            'option_group' => 'crud_group',
            'page' => 'settings/highlight',
            'section_id' => 'highlight',
            "section_description" => 'Highlight',
            'fields' => [
                [
                    'id' => 'theme',
                    "title" => "Theme",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "",
                        "description" => "",
                        "items"=>$styles,
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "jvectormap" => [
            'option_group' => 'crud_group',
            'page' => 'settings/jvectormap',
            'section_id' => 'jvectormap',
            "section_description" => 'jvectormap',
            'fields' => [
                [
                    'id' => 'map',
                    "title" => "Theme",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'language',
                    "title" => "Language",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "crawlers"=>[
            'option_group' => 'crud_group',
            'page' => 'settings/crawlers',
            'section_id' => 'crawlers',
            "section_description" => '机器人/蜘蛛/爬虫',
            'fields' => [
                [
                    'id' => 'map',
                    "title" => "Theme",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "ads"=>[
            'option_group' => 'crud_group',
            'page' => 'ads/index',
            'section_id' => 'ads',
            "section_description" => 'Bing 广告Ads SDK配置',
            'fields' => [
                [
                    'id' => 'apiEnvironment',
                    "title" => "apiEnvironment",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "",
                        "description" => "应用运行环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                        "items"=>[
                            'Production'=>"生产模式",
                            'Sandbox'=>"沙盒模式"
                        ]
                    ],
                ],
//                    "clientId" => "759ca395-1397-4d64-bdf9-586a95b5d017",
//                    "developerToken" => "107385O683686415",
//                    "clientSecret" => "851d0c8b-dc62-4d5f-ad13-955d058d2c85",
//                    "oAuthRefreshTokenPath" => Yii::getAlias("@library/refresh.txt"),
//                    "redirect_uri" => "http://wp.myweb.com/wp-admin/admin.php?page=ads/redirect-uri",
                [
                    'id' => 'clientId',
                    "title" => "clientId",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "应用程序id",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'clientSecret',
                    "title" => "clientSecret",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "应用程序证书",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'developerToken',
                    "title" => "developerToken",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "开发者Token",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'oAuthRefreshTokenPath',
                    "title" => "oAuthRefreshTokenPath",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "Access Token 保存位置",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'redirect_uri',
                    "title" => "redirect_uri",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "http://wp.myweb.com/wp-admin/admin.php?page=ads/redirect-uri",
                        "description" => "回调url",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'apiKey',
                    "title" => "apiKey",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "追踪Flows密钥",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'domain',
                    "title" => "domain",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" =>"", //"http://wp.myweb.com/wp-admin/admin.php?page=ads/redirect-uri",
                        "description" => "追踪Flows域名前缀",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => 'https://go.isenmy.com/admin_api/v1/',
                        ]
                    ],
                ],
            ]
        ],
        "wechat"=>[
            'option_group' => 'crud_group',
            'page' => 'subscription-service',
            'section_id' => 'wechat',
            "section_description" => '微信公众号基础配置',
            'fields' => [
                [
                    'id' => 'environment',
                    "title" => "运行模式",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "Development",
                        "description" => "运行环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                        "items"=>[
                                'Production'=>"生产模式",
                                'Development'=>"开发模式"
                        ]
                    ],
                ],
                [
                    'id' => 'pro-appId',
                    "title" => "appId",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "生产环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'pro-appSecret',
                    "title" => "appSecret",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "生产环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'pro-token',
                    "title" => "Token",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "生产环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'dev-appId',
                    "title" => "appId",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'dev-appSecret',
                    "title" => "appSecret",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'dev-token',
                    "title" => "Token",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
            ]
        ],

    ],
];