<?php

return [
    "menus" => [
        [
            "parent_slug" =>  "index",
            "page_title" => "微信公众号",
            "menu_title" => "微信公众号",
            "menu_slug" => "wechat",
        ],
    ],
    'settings' => [
        "wechat"=>[
            'option_group' => 'crud_group',
            'page' => 'wechat',
            'section_id' => 'wechat',
            "section_description" => '微信公众号基础配置',
            'fields' => [

                [
                    'id' => 'appId',
                    "title" => "appId",
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
                    'id' => 'appSecret',
                    "title" => "appSecret",
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
                    'id' => 'token',
                    "title" => "Token",
                    'args' => [
                        "tag" => "text",
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