<?php

return [
    "menus" => [
        [
            "parent_slug" => "base/index",
            "page_title" => "虚拟电话号码",
            "menu_title" => "虚拟电话号码",
            "menu_slug" => "sms/index",
           'icon_url'=> 'dashicons-phone',
        ],
    ],
    'settings' => [
//        "switch" => [
//            'fields' => [
//                [
//                    "id" => "switch",
//                    "title" => "服务",
//                    'args' => [
//                        "tag" => "switch",
//                        "options" => [
//                            "class" => "regular-text code"
//                        ],
//                        'switch' => [
//                            ["checked" => 1, "description" => "虚拟电话号码", "options" => ["value" => "base/index/icons"]],
//                        ],
//                    ]
//                ]
//            ]
//        ],
        "sms"=>[
            'option_group' => 'crud_group',
            'page' => 'wechat',
            'section_id' => 'sms',
            "section_description" => '虚拟电话号码',
            'fields' => [
                [
                    'id' => 'url',
                    "title" => "Url",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'apiKey',
                    "title" => "apiKey",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "https://api.weixin.qq.com",
                        "description" => "公众平台接口域名池",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
            ]
        ],
    ],
];