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
        'market' => [
            'option_group' => 'crud_group',
            'page' => 'market/index',
            'section_id' => 'market',
            "section_description" => '基础设置',
            "sections"=>[
                ['id'=>"sms","description"=>"阿里云短信接入密钥",'title'=>"Sms"],
                ['id'=>"express","description"=>"快递查询接入密钥",'title'=>"Express"],
            ],
            'fields' => [
                [
                    'id' => 'name',
                    "title" => "名称",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'describe',
                    "title" => "描述",
                    "defaultValue" => "",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
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
                        'afterHtml'=>'<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="选择文件">',
                        "defaultValue" => "",
                        'options' => [
                            //<a onclick="return false;" title="Upload image" class="thickbox" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp;width=640&amp;height=105">Upload Image</a>
                            "class" => "regular-text code"
                        ]
                    ],
                ],

                [
                    'id' => 'accessKeyId',
                    "title" => "AppKey",
                    'section_id' => 'sms',
                    'args' => [
                        "tag" => "text",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'accessKeySecret',
                    "title" => "AppSecret",
                    'section_id' => 'sms',
                    'args' => [
                        "tag" => "text",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'signName',
                    "title" => "SignName",
                    'section_id' => 'sms',

                    'args' => [
                        "tag" => "text",
                        "description" => "短信签名",
                        'options' => [
                            "placeholder"=>"",
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'templateCode',
                    "title" => "TemplateCode",

                    'section_id' => 'sms',
                    'args' => [
                        "tag" => "dropDownList",
                        "items" => [],
                        "description" => "短信发送模版",
                        'options' => [
                            "placeholder"=>"SMS_272575568",
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'AppKey',
                    "title" => "AppKey",
                    'section_id' => 'express',
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'AppSecret',
                    'section_id' => 'express',
                    "title" => "AppSecret",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'AppCode',
                    'section_id' => 'express',
                    "title" => "AppCode",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
            ],
            'args' => [],
        ],
    ],
];