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
//        "flows" => [
//            'option_group' => 'crud_group',
//            'page' => 'ads/index/redirectUri',
//            'section_id' => 'flows',
//            "section_description" => 'Flows追踪配置',
//            'fields' => [
//                [
//                    'id' => 'apiKey',
//                    "title" => "apiKey",
//                    'args' => [
//                        "tag" => "password",
//                        "defaultValue" => "",
//                        "description" => "追踪Flows密钥",
//                        'options' => [
//                            "class" => "regular-text code"
//                        ]
//                    ],
//                ],
//                [
//                    'id' => 'domain',
//                    "title" => "domain",
//                    'args' => [
//                        "tag" => "text",
//                        "defaultValue" => "https://go.isenmy.com/admin_api/v1/",
//                        "description" => "追踪Flows域名前缀",
//                        'options' => [
//                            "class" => "regular-text code",
//                            "placeholder" => 'https://go.isenmy.com/admin_api/v1/',
//                        ]
//                    ],
//                ],
//                [
//                    'id' => 'stream_id',
//                    "title" => "stream_id",
//                    'args' => [
//                        "tag" => "text",
//                        "defaultValue" => "",
//                        'options' => [
//                            "class" => "regular-text code",
//                            "placeholder" => '223',
//                        ]
//                    ],
//                ],
//                [
//                    'id' => 'name',
//                    "title" => "name",
//                    'args' => [
//                        "tag" => "text",
//                        "defaultValue" => "",
//                        'options' => [
//                            "class" => "regular-text code",
//                        ]
//                    ],
//                ],
//                [
//                    'id' => 'mode',
//                    "title" => "mode",
//                    'args' => [
//                        "tag" => "dropDownList",
//                        "defaultValue" => "",
//                        'options' => [
//                            "class" => "regular-text code"
//                        ],
//                        "items" => [
//                            'accept' => "accept",
//                            'reject' => "reject"
//                        ]
//
//                    ],
//                ],
//                [
//                    'id' => 'payload',
//                    "title" => "payload",
//                    "description" => "多个字段使用换行",
//                    'args' => [
//                        "tag" => "textarea",
//                        "defaultValue" => "",
//                        'options' => [
//                            "rows" => "5",
//                            "cols" => "50",
//                            "class" => "large-text code",
//                            "placeholder" => "待输入的文字"
//                        ],
//                    ],
//                ],
//            ]
//        ],
    ],
];