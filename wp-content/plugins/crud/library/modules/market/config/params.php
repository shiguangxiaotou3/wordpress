<?php

return [
    "menus" => [
        [
            "parent_slug" =>  "index",
            "page_title" => "商城",
            "menu_title" => "商城",
            "menu_slug" => "market/index",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "基础设置",
            "menu_title" => "基础设置",
            "menu_slug" => "market/index/settings",
        ],
    ],

    'settings' => [
        'market_config' => [
            'option_group' => 'crud_group',
            'page' => 'market/index/settings',
            'section_id' => 'market_config',
            "section_description" => '基础设置',
            'fields' => [
                [
                    'id' => 'name',
                    "title" => "名称",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "时光小偷的商城",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'describe',
                    "title" => "描述",

                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "时光小偷的商城",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'logo',
                    "title" => "Logo",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "时光小偷的商城",
                        'options' => [
                            //<a onclick="return false;" title="Upload image" class="thickbox" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp;width=640&amp;height=105">Upload Image</a>
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ],
            'args' => [],
        ],
    ],
];