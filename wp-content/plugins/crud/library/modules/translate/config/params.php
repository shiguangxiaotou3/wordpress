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
        [
            "parent_slug" => "translate/index",
            "page_title" => "微软翻译",
            "menu_title" => "微软翻译",
            "menu_slug" => "translate/index/microsoft",
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
                    'id' => 'type',
                    "title" => "type",
                    'args' => [
                        "tag" => "dropDownList",
                        "items"=>[
                            'baidu'=>'百度翻译',
                            'youdao'=>'有道翻译',
                            'google'=>'Google翻译',
                            'microsoft'=>'微软翻译',
                        ],
                        "defaultValue" => "baidu",
                        "description" => "当前使用的api",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
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
                [
                    'id' => 'shortcut',
                    "title" => "快捷方式",
                    'args' => [
                        "tag" => "textarea",
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
                [
                    'id' => 'shortcut',
                    "title" => "快捷方式",
                    'args' => [
                        "tag" => "textarea",
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
                [
                    'id' => 'shortcut',
                    "title" => "快捷方式",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => "",
                        "description" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ]
        ],
        "microsoft" => [
            'option_group' => 'crud_group',
            'page' => 'translate/index/microsoft',
            'section_id' => 'microsoft',
            "section_description" => '有道翻译api配置',
            'fields' => [
                [
                    'id' => 'key',
                    "title" => "key",
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
                    'id' => 'location',
                    "title" => "location",
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
                    'id' => 'shortcut',
                    "title" => "快捷方式",
                    'args' => [
                        "tag" => "textarea",
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