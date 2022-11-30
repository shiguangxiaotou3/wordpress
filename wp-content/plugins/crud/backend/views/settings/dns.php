<?php
/** @var $this yii\web\View */

use yii\web\View;
use crud\models\SettingsSwitch;
use crud\widgets\WpTableWidget;
use crud\widgets\ControllerActionsWidget;
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
        settings_fields("crud_group_dns");
        do_settings_sections("settings/dns");
        submit_button();
        ?>
    </form>
    <?php


        $domains = Yii::$app->dns->domains;
        if( $domains){
            echo WpTableWidget::widget([
                'columns' => [

                    ["field" => "domainName", "title" => '名称'],
                    ["field" => "createTime", "title" => '创建时间'],
                    ["field" => "recordCount", "title" => '解析记录数'],
                    ["field" => "remark", "title" => '备注']
                ],
                "data" => $domains
            ]);
        }

    ?>
</div>

<?php






