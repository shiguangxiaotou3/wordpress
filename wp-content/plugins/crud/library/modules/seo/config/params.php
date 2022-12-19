<?php

return [
    "menus" => [
        [
            "parent_slug" =>  "index",
            "page_title" => "SEO",
            "menu_title" => "SEO",
            "menu_slug" => "seo/index",
        ],
        [
            "parent_slug" =>  "seo/index",
            "page_title" => "百度",
            "menu_title" => "百度",
            "menu_slug" => "seo/index/baidu",
        ],
    ],
    'settings' => [
        'seo_baidu' => [
            'option_group' => 'crud_group',
            'page' => 'seo/index/baidu',
            'section_id' => 'seo_baidu',
            "section_description" => '百度seo配置',
            'fields' => [
                [
                    'id' => 'token',
                    "title" => "token",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "",
                        "options" => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'uli',
                    "title" => "uli",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "",
                        "options" => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ],
            'args' => [],
        ],
    ],
];