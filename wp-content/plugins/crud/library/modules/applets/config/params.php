<?php

return [
    "menus" => [
        [
            "page_title" => "小程序",
            "menu_title" => "小程序",
            "menu_slug" => "applets/index",
        ],
        [
            "parent_slug" =>  "applets/index",
            "page_title" =>"小程序",
            "menu_title" => "小程序",
            "menu_slug" => "applets/index",
        ],
        [
            "parent_slug" =>  "applets/index",
            "page_title" =>"登录",
            "menu_title" => "登录",
            "menu_slug" => "applets/index/login",
        ],
    ],
    'settings' => [
        "applets"=>[
            'option_group' => 'crud_group',
            'page' => 'applets/index',
            'section_id' => 'applets',
            "section_description" => '微信小程序基础配置',
            'fields' => [
                [
                    'id' => 'appId',
                    "title" => "AppId",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "AppID(小程序ID)",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'appSecret',
                    "title" => "AppSecret",
                    'args' => [
                        "tag" => "text",
                        "description" => 'AppSecret(小程序密钥)',
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],

            ]
        ],
    ],
];