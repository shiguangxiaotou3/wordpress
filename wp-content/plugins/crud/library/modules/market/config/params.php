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
        [
            "parent_slug" =>  "market/index",
            "page_title" => "地址管理",
            "menu_title" => "地址管理",
            "menu_slug" => "market/index/address",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "余额管理",
            "menu_title" => "余额管理",
            "menu_slug" => "market/index/money",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "分类管理",
            "menu_title" => "分类管理",
            "menu_slug" => "market/index/categorize",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "商品管理",
            "menu_title" => "商品管理",
            "menu_slug" => "market/index/commodity",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "商品价格管理",
            "menu_title" => "商品价格管理",
            "menu_slug" => "market/index/commodity-price",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "快递管理",
            "menu_title" => "快递管理",
            "menu_slug" => "market/index/express",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "仓库管理",
            "menu_title" => "仓库管理",
            "menu_slug" => "market/index/storehouse",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "用户管理",
            "menu_title" => "用户管理",
            "menu_slug" => "market/index/user",
        ],
        [
            "parent_slug" =>  "market/index",
            "page_title" => "测试",
            "menu_title" => "测试",
            "menu_slug" => "market/index/test",
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
                    'id' => 'appid',
                    "title" => "App Id",
                    'args' => [
                        "tag" => "text",
                        "description" => "小程序",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'appSecret',
                    "title" => "App Secret",
                    'args' => [
                        "tag" => "text",
                        "description" => "小程序",
                        "defaultValue" => "",
                        'options' => [
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
                    'id' => 'yunyang_appid',
                    "title" => "AppKey",
                    'section_id' => 'express',
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "云洋物流",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'yunyang_secretKey',

                    "title" => "AppSecret",
                    'section_id' => 'express',
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "云洋物流",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'qbd_appid',
                    "title" => "AppKey",
                    'section_id' => 'express',
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "QBD",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'qbd_secretKey',
                    'section_id' => 'express',
                    "title" => "AppSecret",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" =>"QBD",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'qbd_host',
                    'section_id' => 'express',
                    "title" => "host",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" =>"QBD",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'yida_username',
                    "title" => "User Name",
                    'section_id' => 'express',
                    'args' => [
                        "tag" => "text",
                        "description" => "易达Api",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'yida_privateKey',
                    'section_id' => 'express',
                    "title" => "Private Key",
                    'args' => [
                        "tag" => "text",

                        "description" =>"易达Api",
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