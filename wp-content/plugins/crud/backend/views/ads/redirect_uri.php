<?php
/** @var $this yii\web\View */
use crud\widgets\ControllerActionsWidget;

?>
<div class="wrap">
    <h1 class="wp-heading-inline">
        <?=  get_admin_page_parent() ?>
        <small><?php echo esc_html( get_admin_page_title() ); ?></small>
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