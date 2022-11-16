<?php
/** @var $this yii\web\View */


use yii\web\View;
use crud\models\SettingsSwitch;
use crud\assets\HighlightAsset;
use crud\widgets\ControllerActionsWidget;


$css = get_option("crud_group_highlight_theme","monokai_sublime.css");
HighlightAsset::register($this);
HighlightAsset::addCssFile($this,"/styles/".$css);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_HEAD);


/**
 * AssetBundle
 */
$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle){
    $this->registerAssetFiles($name);
}

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
    <h1 class="wp-heading-inline">
        <?=  get_admin_page_parent() ?>
        <small><?php echo esc_html( get_admin_page_title() ); ?></small>
    </h1>
    <hr class="wp-header-end" />
    <?php settings_errors(); ?>
    <?= ControllerActionsWidget::widget(["filter" =>function($action){return SettingsSwitch::getSwitch($action);}]); ?>
    <form class="search-form search-plugins" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
            <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
        </p>
    </form>
    <hr style="width: 100%;" />
    <form action="options.php" method="post">
        <?php
        settings_fields("crud_group_highlight");
        do_settings_sections("settings/highlight");
        submit_button();
        ?>
    </form>
    <div style="display: flex;justify-content: space-between">
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








