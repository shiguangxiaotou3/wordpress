<?php
/**
 *
 * @package crud
 */

return [
    'components' => [
        "dns" => [
            'class' =>"crud\modules\base\components\Dns",
            "accessKeyId" => get_option("crud_group_dns_accessKeyId", ""),
            "accessKeySecret" => get_option("crud_group_dns_accessSecret", ""),
        ],
    ],
];