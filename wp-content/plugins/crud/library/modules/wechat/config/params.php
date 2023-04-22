<?php

return [
    "menus" => [
        [
            "parent_slug" => "index",
            "page_title" => "公众号",
            "menu_title" => "公众号",
            "menu_slug" => "wechat/index",
        ],
        [
            "parent_slug" => "wechat/index",
            "page_title" => "菜单设置",
            "menu_title" => "菜单设置",
            "menu_slug" => "wechat/index/menu",
        ],
        //wechat/index/share
        [
            "parent_slug" => "wechat/index",
            "page_title" => "事件推送",
            "menu_title" => "事件推送",
            "menu_slug" => "wechat/index/event",
        ],
        [
            "parent_slug" => "wechat/index",
            "page_title" => "模版消息",
            "menu_title" => "事件消息",
            "menu_slug" => "wechat/index/template",
        ],
        [
            "parent_slug" => "wechat/index",
            "page_title" => "消息",
            "menu_title" => "消息",
            "menu_slug" => "wechat/index/message",
        ],
        [
            "parent_slug" => "wechat/index",
            "page_title" => "分享",
            "menu_title" => "分享",
            "menu_slug" => "wechat/index/share",
        ],
    ],
    'settings' => [
        "wechat" => [
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
                        "tag" => "password",
                        "defaultValue" => "",
                        "description" => "开发环境",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'domain',
                    "title" => "微信开放平台域名",
                    'args' => [
                        "tag" => "dropDownList",
                        "items" => [
                            'https://api.weixin.qq.com' => 'api.weixin.qq.com',
                            'https://api2.weixin.qq.com' => 'api2.weixin.qq.com',
                            'https://sh.api.weixin.qq.com' => 'sh.api.weixin.qq.com',
                            'https://sz.api.weixin.qq.com' => 'sz.api.weixin.qq.com',
                            'https://hk.api.weixin.qq.com' => 'hk.api.weixin.qq.com',
                        ],
                        "defaultValue" => "https://api.weixin.qq.com",
                        "description" => "微信开放平台域名",
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
                        "description" => "开发者服务器验证token",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'encodingAESKey',
                    "title" => "EncodingAESKey",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        "description" => "消息加密密钥由43位字符组成",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'redirect_uri',
                    "title" => "授权后调url",
                    'args' => [
                        "tag" => "text",
                        "defaultValue" => "",
                        'options' => [
                            "class" => "regular-text code"
                        ],
                    ],
                ],
                [
                    'id' => 'jsApiList',
                    "title" => "JS接口列表",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => "",
                        "description" => "使用逗号(英文逗号)或者换行隔开",
                        'options' => [
                            "class" => " large-text code",
                            'rows' => 5,
                            'style' => "width: 500px"
                        ],
                    ],
                ],
            ]
        ],
    ],
];