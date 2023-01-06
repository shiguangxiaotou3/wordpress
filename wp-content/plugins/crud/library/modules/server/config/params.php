<?php
$php =<<<PHP
return [
  "iZicbqe2pd8hmiZ"=>[
    'mail'=>[
      '757402123@outlook.com',
      "a18520871915@163.com"
    ],
    'ips'=>["127.*","192.168.*"],
  ] 
];
PHP;
return [
    "menus" => [
        [
            "parent_slug" =>  "index",
            "page_title" => "服务器",
            "menu_title" => "服务器",
            "menu_slug" => "server/index",
        ],
        [
            "parent_slug" =>  "server/index",
            "page_title" =>"登录记录",
            "menu_title" => "登录记录",
            "menu_slug" => "server/index/login",
        ],
    ],

    'settings' => [
        'server' => [
            'option_group' => 'crud_group',
            'page' => 'server/index/index',
            'section_id' => 'server',
            "section_description" => '白名单',
            'fields' => [
                [
                    'id' => 'gitignore',
                    "title" => "服务器登录白名单",
                    'args' => [
                        "tag" => "textarea",
                        "defaultValue" => $php,
                        "description" => "<code style='color: red'>必须是php代码,会将字符串当作php来执行.</code>",
                        'options' => [
                            "class" => "large-text code",
                            "rows" => 20,
                        ]
                    ],
                ],

            ],
            'args' => [],
        ],
    ],
];

