<?php
/** @var $this yii\web\View */


use yii\web\View;
use crud\models\SettingsSwitch;
use crud\assets\HighlightAsset;
use crud\widgets\PageHeaderWidget;

$options =[
    'controllerOptions'=>[
        "filter" =>function($action){return SettingsSwitch::getSwitch($action);}
    ]
];

$css = get_option("crud_group_highlight_theme","monokai_sublime.css");
HighlightAsset::register($this);
HighlightAsset::addCssFile($this,"/styles/".$css);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_HEAD);



$php =<<<PHP
function my_fun(\$a, \$b){
  return \$a + \$b;
}
var_dump(my_fun(3, 4));
PHP;
$html =<<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
</head>
<body>
</body>
</html>
HTML;
$js =<<<JS
jQuery(function ($) {
// 复制代码
  $(".copy").click(function(){
    alert('复制成功');
  });
});
JS;
?>
<div class="wrap">
    <?= PageHeaderWidget::widget($options) ?>
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_highlight");
        do_settings_sections("base/index/highlight");
        submit_button();
        ?>
    </form>
    <div style="display: flex;justify-content: space-between;flex-wrap: wrap">
        <div style="width: 350px">
            <pre><code  class="language-javascript"><?= $js ?></code></pre>
        </div>
        <div style="width: 350px">
            <pre><code  class="language-html"><?= htmlentities($html) ?></code></pre>
        </div>
        <div style="width: 350px">
            <pre><code  class="language-php"><?= $php ?></code></pre>
        </div>
    </div>

</div>








