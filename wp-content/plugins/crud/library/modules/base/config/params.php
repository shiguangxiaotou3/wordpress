<?php

use crud\models\Files;

/**
 * 非常建议在应用加载前调用yii的类,
 * 但是为了动态加载highlight/styles样式表没办法
 */
$files = Files::getCssFiles("@bower/highlight/styles");
if (!empty($files)) {
    $styles = array_combine($files, $files);
} else {
    $styles = [];
}

return [
    "menus" => [
        // 设置
        [
            "parent_slug" => "index",
            "page_title" => "设置",
            "menu_title" => "设置",
            "menu_slug" => "base/index",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "基础设置",
            "menu_title" => "基础设置",
            "menu_slug" => "base/index/index",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "Ip解析物理地址",
            "menu_title" => "Ip解析物理地址",
            "menu_slug" => "base/index/ipinfo",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "SMTP服务",
            "menu_title" => "SMTP服务",
            "menu_slug" => "base/index/mail",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "Dns解析",
            "menu_title" => "Dns解析",
            "menu_slug" => "base/index/dns",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "代码高亮",
            "menu_title" => "代码高亮",
            "menu_slug" => "base/index/highlight",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "jvectormap",
            "menu_title" => "jvectormap",
            "menu_slug" => "base/index/jvectormap",
        ],
        [
            "parent_slug" => "base/index",
            "page_title" => "爬虫检测",
            "menu_title" => "爬虫检测",
            "menu_slug" => "base/index/crawlers",
        ],
    ],
    'settings' => [
        "switch" => [
            'option_group' => 'crud_group',
            'page' => 'base/index',
            'section_id' => 'switch',
            "section_description" => '启用组件后才回生效',
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
                            ["checked" => 1, "description" => "highlight: 代码高亮显示", "options" => ["value" => "highlight"]],
                            ["checked" => 1, "description" => '机器人/蜘蛛/爬虫', "options" => ["value" => "crawlers"]],
                        ],
                    ]
                ]
            ]
        ],
        'ipinfo' => [
            'option_group' => 'crud_group',
            'page' => 'base/index/ipinfo',
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
            'page' => 'base/index/mail',
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
                    ],
                ],
            ],
            'args' => [],
        ],
        'dns' => [
            'option_group' => 'crud_group',
            'page' => 'base/index/dns',
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

        "highlight" => [
            'option_group' => 'crud_group',
            'page' => 'base/index/highlight',
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
                        "items" => $styles,
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "jvectormap" => [
            'option_group' => 'crud_group',
            'page' => 'base/index/jvectormap',
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
        "crawlers" => [
            'option_group' => 'crud_group',
            'page' => 'base/index/crawlers',
            'section_id' => 'crawlers',
            "section_description" => '机器人/蜘蛛/爬虫',
            'fields' => [
                [
                    'id' => 'ignore',
                    "title" => "忽略ip",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => 'return ["127.*","192.168.*"];',
                        "description" => "不解析物理地址的ip.<code style='color: red'>必须是php代码,词字符串将当作php来执行.</code><br />" .
                            "<pre style='max-width: 300px;margin: 5px'><code class='language-php' >return &#91;'127.*','192.168.*'&#93;&#59;</code></pre>",
                        'options' => [
                            "class" => "large-text code",
                            "rows" => 3,
                        ]
                    ],
                ],
                [
                    'id' => 'blacklist',
                    "title" => "黑名单ip",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => 'return [];',
                        "description" => "禁止访问的ip.<code style='color: red'>必须是php代码,词字符串将当作php来执行.</code><br />" .
                            "<pre style='max-width: 300px;margin: 5px'><code class='language-php'>return &#91;&#93;&#59;&#10;</code></pre>",
                        'options' => [
                            "class" => "large-text code",
                            "rows" => 3,
                        ]
                    ],
                ],
            ]
        ],

    ],
];