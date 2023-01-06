<?php
/** @var $this yii\web\View */

/** @var $data array|null */
use crud\widgets\PageHeaderWidget;
use crud\widgets\WpTableWidget;
?>

    <div class="wrap">
        <?= PageHeaderWidget::widget() ?>
        <?php
        if(isset($data) and !empty($data)){
            echo WpTableWidget::widget([
                "data" =>$data,
                'columns' => [
                    [
                        "field" => "server",
                        "title" => '服务器名称',
                    ],
                    [
                        "field" => "name",
                        "title" => '登录名',
                    ],

                    [
                        "field" => "ip",
                        "title" => '登录ip',
                    ],
                    [
                        "field" => "time",
                        "title" => '登录时间',
                    ],
                ]
            ]);
        }
        ?>
    </div>
<?php

