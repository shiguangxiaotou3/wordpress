<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
use crud\modules\market\assets\MarketAsset;

MarketAsset::register($this);
$js ="";
$path =Yii::getAlias("@crud/modules/market/views/index/component");
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
        <content-phone  @dragenter="dragenter" @create="create"></content-phone>
        <content-settings @dragstart="dragstart" @create="create"></content-settings>
    </div>
</div>

<?php
$js .=<<<JS
const app2 = new Vue({
  el: '#app',
  data: {
      options:''
  },
  //监听
  watch: {},
  //计算属性
  computed: {},
  //方法
  methods: {
    dragenter(e){
      console.log('父 进入')
      console.log(this.options)
      return  this.options;
    },
    dragstart(e){
        console.log('父 开始拖拽')
        console.log(e)
       this.options =e
    },
    create(event){
        console.log(this.\$refs.content);
        event.preventDefault()
     const el = new Vue({
        render: h => h(this.options.tag, {
          attrs: this.options.tag,
          on: {
            // click: () => console.log('clicked'),
            // dragstart:this.dragstart,
            // mouseover: this.myMouseover,
            // mouseleave: this.myMouseleave
          }
        }, '这是一个测试元素')
      });
      el.\$mount();
      this.\$refs.content.appendChild(el.\$el);
    }
  },
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

