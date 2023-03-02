<?php
/** @var $this yii\web\View */
use crud\widgets\PageHeaderWidget;
use yii\helpers\Html;
use crud\assets\VueAsset;
use crud\assets\LayuiAsset;
$sms = Yii::$app->smsComponent;
$country=json_encode( $sms->getCountry());
$server = json_encode( $sms ->getService());
VueAsset::register($this);
LayuiAsset::register($this)
?>
<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div class="layui-container"  id="app">
        <div class="layui-row"></div>


        <div class="layui-row">
            <table id="demo" lay-filter="test"></table>
        </div>
    </div>
</div>
<?php
$js = <<<JS
Vue.prototype.$ = jQuery;
Vue.prototype.Layui = layui;
const app2 = new Vue({
  el: '#app',
  data: {
    country:{$country},
    server:{$server},
    table:[]
  },
  //监听
  watch: {},
  //计算属性
  computed: {},
  //方法
  methods: {
  },
  //生命周期 - 创建完成
  created() {
     this.showTable()
   },
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