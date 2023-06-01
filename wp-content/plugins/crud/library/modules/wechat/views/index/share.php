<?php
/** @var $this yii\web\View */



use crud\widgets\PageHeaderWidget;
$wechat = Yii::$app->subscription;

?>

<div class="wrap">
    <?= PageHeaderWidget::widget() ?>

    <?php
        $results =$wechat->response( $wechat->client->get("/cgi-bin/token", [
            'query' => [
                "grant_type" => 'client_credential',
                'appid' => $wechat->appId,
                'secret' =>$wechat->appSecret,
            ]
        ]));
        dump($results);



    ?>
</div>