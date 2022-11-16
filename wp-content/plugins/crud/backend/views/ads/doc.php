<?php
/** @var $this yii\web\View */
/** @var $myText  */

use yii\web\View;
use yii\helpers\Markdown;
use crud\assets\HighlightAsset;
use crud\widgets\ControllerActionsWidget;

$css = get_option("crud_group_highlight_theme","monokai_sublime.css");
HighlightAsset::register($this);
HighlightAsset::addCssFile($this,"/styles/".$css);
$this->registerJs('hljs.initHighlightingOnLoad();',View::POS_HEAD);
$css =<<<CSS
#doc img{
max-width: 100%; height: auto; width: auto; width: auto
}
CSS;
$this->registerCss($css);
?>


<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?>
        <small> 文档</small>
    </h1>
    <hr class="wp-header-end" />
    <?php settings_errors(); ?>
    <?= ControllerActionsWidget::widget(); ?>
    <form class="search-form search-plugins" method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="plugin-search-input">搜索已安装的插件:</label>
            <input type="search" id="plugin-search-input" class="wp-filter-search" name="s" value="" placeholder="搜索已安装的插件…" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索已安装的插件">
        </p>
    </form>
    <hr style="width: 100%;" />
        <div id="doc" style="background-color: rgba(220,220,220,0.5);padding: 10px">
            <?=  Markdown::process($myText, 'gfm-comment') ?>
        </div>
    <hr style="width: 100%;" />

</div>
<?php
$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle){
    $this->registerAssetFiles($name);
}