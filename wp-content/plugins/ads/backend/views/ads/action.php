<?php
/** @var $this yii\web\View */
/** @var $data string */

use yii\helpers\Html;
use crud\widgets\ControllerActionsWidget;

?>


<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?>
        <small> <?=  Html::a("获取访问许可","#",["class"=>"button button-success"]) ?></small>
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
</div>
<?php
$bundles = $this->getAssetManager()->bundles;
foreach ($bundles as $name => $bundle){
    $this->registerAssetFiles($name);
}