<?php
use crud\models\Files;

/**
 * 非常建议在应用加载前调用yii的类,
 * 但是为了动态加载highlight/styles样式表没办法
 */
$files = Files::getCssFiles("@bower/highlight/styles");
if(!empty(  $files)){
    $styles =array_combine($files,$files);
}else{
    $styles =[];
}


return [
    "menus" => [
        // Bing广告api SDK
        [
//            "parent_slug" =>  "index",
            "page_title" => "Bing Ads",
            "menu_title" =>  "Bing Ads",
            "menu_slug" => "ads",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "Flows配置",
            "menu_title" => "Flows配置",
            "menu_slug" => "ads/redirect-uri",
        ],
        [
            "parent_slug" =>  "ads",
            "page_title" => "面板",
            "menu_title" => "面板",
            "menu_slug" => "ads/test",
        ],
//        [
//            "parent_slug" =>  "ads",
//            "page_title" => "Flows在线测试",
//            "menu_title" => "Flows在线测试",
//            "menu_slug" => "ads/flows",
//        ],



    ],
    'settings' => [
        "flows"=>[
            'option_group' => 'crud_group',
            'page' => 'ads/redirectUri',
            'section_id' => 'flows',
            "section_description" => 'Flows追踪配置',
            'fields' => [
                [
                    'id' => 'apiKey',
                    "title" => "apiKey",
                    'args' => [
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "追踪Flows密钥",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'domain',
                    "title" => "domain",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" =>"https://go.isenmy.com/admin_api/v1/",
                        "description" => "追踪Flows域名前缀",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => 'https://go.isenmy.com/admin_api/v1/',
                        ]
                    ],
                ],
                [
                    'id' => 'stream_id',
                    "title" => "stream_id",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" =>"",
                        'options' => [
                            "class" => "regular-text code",
                            "placeholder" => '223',
                        ]
                    ],
                ],
                [
                    'id' => 'name',
                    "title" => "name",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" =>"",
                        'options' => [
                            "class" => "regular-text code",
                        ]
                    ],
                ],
                [
                    'id' => 'mode',
                    "title" => "mode",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                        "items"=>[
                            'accept'=>"accept",
                            'reject'=>"reject"
                        ]

                    ],
                ],
                [
                    'id' => 'payload',
                    "title" => "payload",
                    "description" => "多个字段使用换行",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => "",
                        'options' => [
                            "rows"=>"5",
                            "cols"=>"50",
                            "class"=>"large-text code",
                            "placeholder"=>"待输入的文字"
                        ],
                    ],
                ],
            ]
        ],
        "ads"=>[
            'option_group' => 'crud_group',
            'page' => 'ads/index',
            'section_id' => 'ads',
            "section_description" => 'Bing 广告Ads SDK配置',
            'fields' => [
                [
                    'id' => 'apiEnvironment',
                    "title" => "apiEnvironment",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "",
                        "description" => "应用运行环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                        "items"=>[
                            'Production'=>"生产模式",
                            'Sandbox'=>"沙盒模式"
                        ]
                    ],
                ],
                [
                    'id' => 'clientId',
                    "title" => "clientId",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "应用程序id",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'clientSecret',
                    "title" => "clientSecret",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "应用程序证书",
                        'options' => [
                            "class" => "regular-text code"
                        ],

                    ],
                ],
                [
                    'id' => 'oAuthScope',
                    "title" => "oAuthScope",
                    'args' => [
                        "tag" => "dropDownList",
                        "defaultValue" => "msads.manage",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                        "items"=>[
                            'msads.manage'=>"msads.manage",
                            'bingads.manage'=>"bingads.manage",
                            'ads.manage'=>'ads.manage'
                        ],
                    ],
                ],
                [
                    'id' => 'developerToken',
                    "title" => "developerToken",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "开发者Token",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'oAuthRefreshTokenPath',
                    "title" => "oAuthRefreshTokenPath",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "Access Token 保存位置",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'redirect_uri',
                    "title" => "redirect_uri",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "http://wp.myweb.com/wp-admin/admin.php?page=ads/redirect-uri",
                        "description" => "回调url",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'accountId',
                    "title" => "AccountId",
                    'args' => [
                        "tag" => "text",
                        "description" =>"客户帐户ID",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'customerId',
                    "title" => "CustomerId",
                    "description" =>"客户ID",
                    'args' => [
                        "tag" => "text",
                        "description" =>"客户帐户ID",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                [
                    'id' => 'campaignId',
                    "title" => "campaignId",
                    "description" =>"广告系列id",
                    'args' => [
                        "tag" => "text",
                        "description" =>"客户帐户ID",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],
                //campaignId
                [
                    'id' => 'adGroupId',
                    "title" => "adGroupId",
                    "description" =>"adGroupId",
                    'args' => [
                        "tag" => "text",
                        "description" =>"adGroupId",
                        'options' => [
                            "class" => "regular-text code"
                        ]
                    ],
                ],

            ]
        ],
    ],
];