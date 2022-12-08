<?php
?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <hr class="wp-header-end">
    <?php settings_errors(); ?>

    <ul class="subsubsub">
        <li class="all">
            <a href="plugins.php?plugin_status=all" class="current" aria-current="page">
                全部<span class="count">（10）</span>
            </a> |
        </li>
        <li class="active">
            <a href="plugins.php?plugin_status=active">已启用<span class="count">（8）</span></a> |
        </li>
        <li class="inactive">
            <a href="plugins.php?plugin_status=inactive">未启用<span class="count">（2）</span></a> |
        </li>
        <li class="dropins">
            <a href="plugins.php?plugin_status=dropins">强化扩展<span class="count">（1）</span></a> |
        </li>
        <li class="auto-update-enabled"><a href="plugins.php?plugin_status=auto-update-enabled">自动更新已启用<span
                        class="count">（2）</span></a> |
        </li>
        <li class="auto-update-disabled"><a href="plugins.php?plugin_status=auto-update-disabled">自动更新已禁用<span
                        class="count">（8）</span></a></li>
    </ul>



    <form action="options.php" method="post">
        <?php
            settings_fields("crud_group");
            do_settings_sections("index/settings");
            submit_button();
        ?>
    </form>
</div>


