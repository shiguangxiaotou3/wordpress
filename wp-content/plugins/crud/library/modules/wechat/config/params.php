<?php

return [
    "menus" => [
        [
            "parent_slug" =>  "index",
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
        [
            "parent_slug" =>  "wechat/index",
            "page_title" => "事件推送",
            "menu_title" => "事件推送",
            "menu_slug" => "wechat/index/event",
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
                    'id' => 'domain',
                    "title" => "domain",
                    'args' => [
                        "tag" => "dropDownList",
                        "items"=>[
                            'https://api.weixin.qq.com'=>'api.weixin.qq.com',
                            'https://api2.weixin.qq.com'=>'api2.weixin.qq.com',
                            'https://sh.api.weixin.qq.com'=>'sh.api.weixin.qq.com',
                            'https://sz.api.weixin.qq.com'=>'sz.api.weixin.qq.com',
                            'https://hk.api.weixin.qq.com'=>'hk.api.weixin.qq.com',
                        ],
                        "defaultValue" => "https://api.weixin.qq.com",
                        "description" => "公众平台接口域名池",
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