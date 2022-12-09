<?php

return [
    "menus" => [
        [
            "parent_slug" => "index",
            "page_title" => "翻译",
            "menu_title" => "翻译",
            "menu_slug" => "translate/index",
        ],
        [
            "parent_slug" => "translate/index",
            "page_title" => "Google翻译",
            "menu_title" => "Google翻译",
            "menu_slug" => "translate/index/google",
        ],
        [
            "parent_slug" => "translate/index",
            "page_title" => "有道翻译",
            "menu_title" => "有道翻译",
            "menu_slug" => "translate/index/youdao",
        ],
        [
            "parent_slug" => "translate/index",
            "page_title" => "百度翻译",
            "menu_title" => "百度翻译",
            "menu_slug" => "translate/index/baidu",
        ],
    ],
    'settings' => [
        "google" => [
            'option_group' => 'crud_group',
            'page' => 'translate/index/google',
            'section_id' => 'google',
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
        "baidu" => [
            'option_group' => 'crud_group',
            'page' => 'translate/index/baidu',
            'section_id' => 'baidu',
            "section_description" => '百度翻译api配置',
            'fields' => [
                [
                    'id' => 'appId',
                    "title" => "appId",
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
                    'id' => 'appSecret',
                    "title" => "appSecret",
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
        "youdao" => [
            'option_group' => 'crud_group',
            'page' => 'translate/index/youdao',
            'section_id' => 'youdao',
            "section_description" => '有道翻译api配置',
            'fields' => [
                [
                    'id' => 'appId',
                    "title" => "appId",
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
                    'id' => 'appSecret',
                    "title" => "appSecret",
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
    ],
];