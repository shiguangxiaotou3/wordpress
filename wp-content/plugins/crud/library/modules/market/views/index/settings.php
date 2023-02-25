<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;

MarketAsset::register($this);
$js ="";
$path =Yii::getAlias("@library/modules/market/views/index/component");
if ($handle = opendir($path)) {
    while (false !== ($item = readdir($handle))) {
        if ($item != "." && $item != "..") {
            if(file_exists("$path/$item")){
                $js .= file_get_contents("$path/$item");
            }
        }
    }
    closedir($handle);
}
?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div class="settings-content" id="app">
        <content-phone></content-phone>
        <content-settings></content-settings>
    </div>
</div>

<?php


$js .=<<<JS
const app2 = new Vue({
  el: '#app',
  data: {},
  //监听
  watch: {},
  //计算属性
  computed: {},
  //方法
  methods: {},
  //生命周期 - 创建完成
  created() { },
  //生命周期 - 挂载完成
  mounted() { },
  //生命周期 - 创建之前
  beforeCreate() { },
  //生命周期- 挂载之前
  beforeMount() { },
  //生命周期 - 更新之前
  beforeUpdate() { },
  //生命周期 - 更新之后
  updated() { },
  //生命周期- 销毁之前
  beforeDestroy() { },
  //生命周期- 销毁完成
  destroyed() { },
  //如果页面有keep-alive 缓存功能，这个函数会触发
  activated() { }
});
JS;
$this->registerJs($js);


$template =<<<JS
new Vue({
  el: '#app',
  data: {},
  //监听
  watch: {},
  //计算属性
  computed: {},
  //方法
  methods: {},
  //生命周期 - 创建完成
  created() { },
  //生命周期 - 挂载完成
  mounted() { },
  //生命周期 - 创建之前
  beforeCreate() { },
  //生命周期- 挂载之前
  beforeMount() { },
  //生命周期 - 更新之前
  beforeUpdate() { },
  //生命周期 - 更新之后
  updated() { },
  //生命周期- 销毁之前
  beforeDestroy() { },
  //生命周期- 销毁完成
  destroyed() { },
  //如果页面有keep-alive 缓存功能，这个函数会触发
  activated() { },
});

Vue.component("view_test", {
  data(){},
  pros:[],
  template: ``,
  //监听
  watch: {},
  //计算属性
  computed: {},
  //方法
  methods: {},
  //生命周期 - 创建完成
  created() { },
  //生命周期 - 挂载完成
  mounted() { },
  //生命周期 - 创建之前
  beforeCreate() { },
  //生命周期- 挂载之前
  beforeMount() { },
  //生命周期 - 更新之前
  beforeUpdate() { },
  //生命周期 - 更新之后
  updated() { },
  //生命周期- 销毁之前
  beforeDestroy() { },
  //生命周期- 销毁完成
  destroyed() { },
  //如果页面有keep-alive 缓存功能，这个函数会触发
  activated() { },
});

JS;

