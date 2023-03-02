<?php

return [
    "menus" => [
        [
            "parent_slug" => "index",
            "page_title" => "虚拟电话号码",
            "menu_title" => "虚拟电话号码",
            "menu_slug" => "sms/index",
        ],
        [
            "parent_slug" => "sms/index",
            "page_title" => "测试",
            "menu_title" => "测试",
            "menu_slug" => "sms/index/test",
        ],
    ],
    'settings' => [
        "sms"=>[
            'option_group' => 'crud_group',
            'page' => 'sms/index',
            'section_id' => 'sms',
            "section_description" => '虚拟电话号码',
            'fields' => [
                [
                    'id' => 'url',
                    "title" => "请求地址",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "https://api.sms-activate.org/stubs/handler_api.php",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'apiKey',
                    "title" => "密钥",
                    'args' => [
                        "tag" => "text",
                        "description" => "密钥",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ]
            ]
        ],
    ],
];