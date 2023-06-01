<?php


return [
    "menus" => [
        // 首页
        [
            "page_title" => "Crud Plugins",
            "menu_title" => "Crud Plugins",
            "capability" => 'manage_options',
            "menu_slug" => "index",
            "icon_url" => 'dashicons-align-full-width'
        ],
//        // 空白
//        [
//            "parent_slug" => "index",
//            "page_title" => "Home",
//            "menu_title" => "Home",
//            "menu_slug" =>  "index",
//        ],
        [
            "parent_slug" => "index/index",
            "page_title" => "模块加载",
            "menu_title" => "模块加载",
            "menu_slug" =>  "index/modules",
        ],
        [
            "parent_slug" => "index/index",
            "page_title" => "错误",
            "menu_title" => "错误",
            "menu_slug" =>  "index/error",
        ],
        [
            "parent_slug" => "index/index",
            "page_title" => "路由",
            "menu_title" => "路由",
            "menu_slug" =>  "index/rules",
        ],
        [
            "parent_slug" => "index/index",
            "page_title" => "样式",
            "menu_title" => "样式",
            "menu_slug" =>  "index/style",
        ],
        //rules
        [
            "parent_slug" => "index/index",
            "page_title" => "Icons",
            "menu_title" => "Icons",
            "menu_slug" => "index/icons",
        ],
    ],
    'settings' => [

    ],
];