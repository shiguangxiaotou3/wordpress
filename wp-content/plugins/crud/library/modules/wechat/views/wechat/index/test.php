<?php
/** @var $this yii\web\View */
/** @var $wechat crud\modules\wechat\components\SubscriptionService */

$wechat = Yii::$app->subscription;


?>
    <div class="warp">
        <div style="width: 100%">
            <h1></h1>
        </div>
        <div style="width: 100%">
            <pre><code></code></pre>
        </div>
    </div>
<?php
$config = json_encode( $wechat ->getJsConfig());
$js =<<<JS
    var config =$config;
    wx.config(config);
    wx.ready(function(res){
      $('h1').append('JSSDK验证签名通过');
      $('code').append(JSON.stringify(config,null,4));
    });
    
    wx.error(function(res){
        $('h1').append('JSSDK验证签名失败')
       $('code').append(JSON.stringify(res,null,4));
    });
JS;

$this->registerJs($js);
