<?php
/** @var $this yii\web\View */
/** @var $subscription SubscriptionService*/

use crud\modules\wechat\components\SubscriptionService;
use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;
$wechat = Yii::$app->subscription;
MarketAsset::register($this);
?>
<div class="wrap" id="app">
    <?= PageHeaderWidget::widget() ?>
</div>

<?php


$js =<<<JS
const app2 = new Vue({
    el: '#app',
    data(){
        return {
           
        }
    },
    //监听
    watch: {
        
    },
    //计算属性
    computed: {
      
    },
    //方法
    methods: {
    },
    //生命周期 - 创建完成
    created() { },
    //生命周期 - 挂载完成
    mounted() {
    },
});

JS;
$this->registerJs($js);


