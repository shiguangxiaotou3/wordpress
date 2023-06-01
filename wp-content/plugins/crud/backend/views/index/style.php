
<?php
/** @var $this yii\web\View */

use crud\widgets\PageHeaderWidget;
?>


<div class="wrap">
    <?= PageHeaderWidget::widget()  ?>
    <h2>通知</h2>
    <?php
    $arr=['',"notice-error", "notice-warning", "notice-success", "notice-dismiss", "notice-title", "notice-large", "notice-alt"];
    foreach ($arr as $item){
        ?>
        <div id="message" class="<?= $item ?> notice">
            <p><strong>您知道吗？</strong></p>
            <p>无需在此处更改 CSS — 您可以在<a href="https://www.shiguangxiaotou.com/wp-admin/customize.php?autofocus%5Bsection%5D=custom_css">内置 CSS 编辑器</a>中编辑和实时预览 CSS 更改。</p>
        </div>
    <?php } ?>
    <div class="notice notice-success settings-error is-dismissible">
        <p><strong>您知道吗？</strong></p>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button>
    </div>
    <div class="notice notice-warning settings-error is-dismissible">
        <p><strong>您知道吗？</strong></p>
        <button type="button" class="notice-dismiss"><span class="screen-reader-text">忽略此通知。</span></button>
    </div>

    <h2>按钮</h2>
    <div>
        <div class="button-primary">asd</div>
        <div class="button-secondary">asd</div>
        <div class="button button-large">asd</div>
        <div class="button button-small">asd</div>
        <div class=" button-group">
            <div class="button last-child">asd</div>
            <div class="button ">asd</div>
            <div class="button first-child">asd</div>
        </div>
        <div class="button button-link">asd</div>
        <div class="button button-link-delete">asd</div>
        <div class="button button-disabled">asd</div>
        <div class="button installed">asd</div>
        <div class="button button-primary">asd</div>
    </div>

    <h2>选项卡2</h2>
    <div class="wp-picker-container wp-color-result">
        <?php
        $arr2 =['wp-color-picker','wp-picker-container','wp-picker-input-wrap','wp-color-result-text',
            'wp-picker-open','iris-picker','wp-color-result-text','wp-picker-clear','wp-picker-default','','','','', '','','','','','','','','',
            '','','','','','','','','',
            '','','','','','','','','',
            '','','','','','','','','',
            '','','','','','','','','',];
        foreach ($arr2 as $item){
            echo "<div class=\"$item\">$item</div>";
        }
        ?>

    </div>
    <h2>顶部</h2>
    <div id="screen-meta" class="metabox-prefs" style="display: block;">

        <div id="contextual-help-wrap" class="" tabindex="-1" aria-label="“上下文帮助”选项卡" style="display: block;">
            <div id="contextual-help-back"></div>
            <div id="contextual-help-columns">
                <div class="contextual-help-tabs">
                    <ul>

                        <li id="tab-link-overview" class="active">
                            <a href="#tab-panel-overview" aria-controls="tab-panel-overview">
                                概述								</a>
                        </li>

                        <li id="tab-link-attachment-details">
                            <a href="#tab-panel-attachment-details" aria-controls="tab-panel-attachment-details">
                                附件详情								</a>
                        </li>
                    </ul>
                </div>

                <div class="contextual-help-sidebar">
                    <p><strong>更多信息：</strong></p><p><a href="https://wordpress.org/support/article/media-library-screen/">媒体库文档</a></p><p><a href="https://cn.wordpress.org/support/">支持</a></p>					</div>

                <div class="contextual-help-tabs-wrap">

                    <div id="tab-panel-overview" class="help-tab-content active">
                        <p>您上传的所有文件都在“媒体库”界面中按上传时间顺序列出，最新上传的显示在最前面。</p><p>您可以简单的网格视图或列表视图两种方式来查阅您的媒体文件。您可以使用媒体文件列表左上侧的图标来切换这些视图。</p><p>要删除媒体项目，点击顶部的“批量选择”按钮，选择您想要删除的项目，再点击“删除所选”按钮。如您想返回查阅媒体，请点击“取消选择”按钮。</p>							</div>

                    <div id="tab-panel-attachment-details" class="help-tab-content">
                        <p>点选一个项目将会带出“附件详情”对话框，您可在其中预览媒体并快速做出修改。您在“附件详情”对话框中做出的所有修改都会自动保存。</p><p>使用对话框顶部的箭头按钮或键盘上的左右键，便能快速浏览媒体项目。</p><p>您也可以在此详情对话框中删除单个项目或访问扩展编辑界面。</p>							</div>
                </div>
            </div>
        </div>
    </div>


    <h2>选项卡2</h2>
    <div class="wp-filter">
        <ul class="filter-links">
            <li class="plugin-install-featured"><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=featured" class="current" aria-current="page">特色</a> </li>
            <li class="plugin-install-popular"><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=popular">热门</a> </li>
            <li class="plugin-install-recommended"><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=recommended">推荐</a> </li>
            <li class="plugin-install-favorites"><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=favorites">收藏</a></li>
        </ul>

        <form class="search-form search-plugins" method="get">
            <input type="hidden" name="tab" value="search">
            <label class="screen-reader-text" for="typeselector">搜索插件：</label>
            <select name="type" id="typeselector">
                <option value="term" selected="selected">关键字</option>
                <option value="author">作者</option>
                <option value="tag">标签</option>
            </select>
            <label class="screen-reader-text" for="search-plugins">搜索插件</label>
            <input type="search" name="s" id="search-plugins" value="" class="wp-filter-search" placeholder="搜索插件…" aria-describedby="live-search-desc">
            <input type="submit" id="search-submit" class="button hide-if-js" value="搜索插件">
        </form>
    </div>

    <h2>卡片</h2>
    <div class="card">
        <h2 class="title">分类与标签转换器</h2>
        <p>如果您想将分类转为标签（或者反过来），可以选用“导入”页面上的<a href="import.php">分类与标签转换器</a>来实现</p>
    </div>

    <h2>卡片2</h2>
    <div class="theme-browser rendered">
        <div class="themes wp-clearfix">
            <div class="theme active" data-slug="twentyten">

                <div class="theme-screenshot">
                    <img src="https://www.shiguangxiaotou.com/wp-content/themes/twentyten/screenshot.png?ver=3.7" alt="">
                </div>

                <button type="button" aria-label="查看 Twenty Ten 的主题详情" class="more-details" id="twentyten-action">主题详情</button>
                <div class="theme-author">作者：WordPress团队	</div>
                <div class="theme-id-container">
                    <h2 class="theme-name" id="twentyten-name">
                        <span>已启用：</span> Twenty Ten
                    </h2>
                    <div class="theme-actions">
                        <a aria-label="自定义 Twenty Ten" class="button button-primary customize load-customize hide-if-no-customize" href="https://www.shiguangxiaotou.com/wp-admin/customize.php?theme=twentyten&amp;return=%2Fwp-admin%2Fthemes.php">自定义</a>
                    </div>
                </div>
            </div>
            <div class="theme add-new-theme"><a href="https://www.shiguangxiaotou.com/wp-admin/theme-install.php"><div class="theme-screenshot"><span></span></div><h2 class="theme-name">添加新主题</h2></a></div>
        </div>
    </div>


    <div class="plugins-popular-tags-wrapper">
        <h2>云图</h2>
        <p>您也可以浏览插件目录中最流行的标签：</p>
        <p class="popular-tags"><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=admin" class="tag-cloud-link tag-link-admin tag-link-position-1" style="font-size: 17.882352941176pt;" aria-label="admin (2个插件)">admin</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=ads" class="tag-cloud-link tag-link-ads tag-link-position-2" style="font-size: 10pt;" aria-label="ads (568个插件)">ads</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=affiliate" class="tag-cloud-link tag-link-affiliate tag-link-position-3" style="font-size: 10.352941176471pt;" aria-label="affiliate (617个插件)">affiliate</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=ajax" class="tag-cloud-link tag-link-ajax tag-link-position-4" style="font-size: 10.823529411765pt;" aria-label="ajax (673个插件)">ajax</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=analytics" class="tag-cloud-link tag-link-analytics tag-link-position-5" style="font-size: 12.117647058824pt;" aria-label="analytics (873个插件)">analytics</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=api" class="tag-cloud-link tag-link-api tag-link-position-6" style="font-size: 10.235294117647pt;" aria-label="api (607个插件)">api</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=block" class="tag-cloud-link tag-link-block tag-link-position-7" style="font-size: 11.529411764706pt;" aria-label="block (781个插件)">block</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=blocks" class="tag-cloud-link tag-link-blocks tag-link-position-8" style="font-size: 8.9411764705882pt;" aria-label="blocks (472个插件)">blocks</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=buddypress" class="tag-cloud-link tag-link-buddypress tag-link-position-9" style="font-size: 11.529411764706pt;" aria-label="buddypress (781个插件)">buddypress</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=button" class="tag-cloud-link tag-link-button tag-link-position-10" style="font-size: 9.6470588235294pt;" aria-label="button (530个插件)">button</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=cache" class="tag-cloud-link tag-link-cache tag-link-position-11" style="font-size: 8.1176470588235pt;" aria-label="cache (393个插件)">cache</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=calendar" class="tag-cloud-link tag-link-calendar tag-link-position-12" style="font-size: 9.2941176470588pt;" aria-label="calendar (502个插件)">calendar</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=categories" class="tag-cloud-link tag-link-categories tag-link-position-13" style="font-size: 9.6470588235294pt;" aria-label="categories (538个插件)">categories</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=category" class="tag-cloud-link tag-link-category tag-link-position-14" style="font-size: 10.941176470588pt;" aria-label="category (684个插件)">category</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=chat" class="tag-cloud-link tag-link-chat tag-link-position-15" style="font-size: 9.7647058823529pt;" aria-label="chat (552个插件)">chat</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=code" class="tag-cloud-link tag-link-code tag-link-position-16" style="font-size: 8.2352941176471pt;" aria-label="code (405个插件)">code</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=comment" class="tag-cloud-link tag-link-comment tag-link-position-17" style="font-size: 9.8823529411765pt;" aria-label="comment (567个插件)">comment</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=comments" class="tag-cloud-link tag-link-comments tag-link-position-18" style="font-size: 16.117647058824pt;" aria-label="comments (1个插件)">comments</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=contact" class="tag-cloud-link tag-link-contact tag-link-position-19" style="font-size: 10.235294117647pt;" aria-label="contact (596个插件)">contact</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=contact+form" class="tag-cloud-link tag-link-contact-form tag-link-position-20" style="font-size: 11.176470588235pt;" aria-label="contact form (721个插件)">contact form</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=contact+form+7" class="tag-cloud-link tag-link-contact-form-7 tag-link-position-21" style="font-size: 9.6470588235294pt;" aria-label="contact form 7 (532个插件)">contact form 7</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=content" class="tag-cloud-link tag-link-content tag-link-position-22" style="font-size: 12.117647058824pt;" aria-label="content (866个插件)">content</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=css" class="tag-cloud-link tag-link-css tag-link-position-23" style="font-size: 10.352941176471pt;" aria-label="css (622个插件)">css</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=custom" class="tag-cloud-link tag-link-custom tag-link-position-24" style="font-size: 9.8823529411765pt;" aria-label="custom (565个插件)">custom</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=dashboard" class="tag-cloud-link tag-link-dashboard tag-link-position-25" style="font-size: 10.117647058824pt;" aria-label="dashboard (590个插件)">dashboard</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=e-commerce" class="tag-cloud-link tag-link-e-commerce tag-link-position-26" style="font-size: 12.941176470588pt;" aria-label="e-commerce (1个插件)">e-commerce</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=ecommerce" class="tag-cloud-link tag-link-ecommerce tag-link-position-27" style="font-size: 14.823529411765pt;" aria-label="ecommerce (1个插件)">ecommerce</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=editor" class="tag-cloud-link tag-link-editor tag-link-position-28" style="font-size: 11.411764705882pt;" aria-label="editor (765个插件)">editor</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=elementor" class="tag-cloud-link tag-link-elementor tag-link-position-29" style="font-size: 11.176470588235pt;" aria-label="elementor (727个插件)">elementor</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=email" class="tag-cloud-link tag-link-email tag-link-position-30" style="font-size: 14.352941176471pt;" aria-label="email (1个插件)">email</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=embed" class="tag-cloud-link tag-link-embed tag-link-position-31" style="font-size: 10.941176470588pt;" aria-label="embed (686个插件)">embed</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=events" class="tag-cloud-link tag-link-events tag-link-position-32" style="font-size: 9.6470588235294pt;" aria-label="events (541个插件)">events</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=facebook" class="tag-cloud-link tag-link-facebook tag-link-position-33" style="font-size: 14.941176470588pt;" aria-label="facebook (1个插件)">facebook</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=feed" class="tag-cloud-link tag-link-feed tag-link-position-34" style="font-size: 10.941176470588pt;" aria-label="feed (684个插件)">feed</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=form" class="tag-cloud-link tag-link-form tag-link-position-35" style="font-size: 12.117647058824pt;" aria-label="form (872个插件)">form</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=forms" class="tag-cloud-link tag-link-forms tag-link-position-36" style="font-size: 9.5294117647059pt;" aria-label="forms (522个插件)">forms</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=gallery" class="tag-cloud-link tag-link-gallery tag-link-position-37" style="font-size: 14pt;" aria-label="gallery (1个插件)">gallery</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=gateway" class="tag-cloud-link tag-link-gateway tag-link-position-38" style="font-size: 8.4705882352941pt;" aria-label="gateway (421个插件)">gateway</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=google" class="tag-cloud-link tag-link-google tag-link-position-39" style="font-size: 15.058823529412pt;" aria-label="google (1个插件)">google</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=gutenberg" class="tag-cloud-link tag-link-gutenberg tag-link-position-40" style="font-size: 11.882352941176pt;" aria-label="gutenberg (823个插件)">gutenberg</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=image" class="tag-cloud-link tag-link-image tag-link-position-41" style="font-size: 15.058823529412pt;" aria-label="image (1个插件)">image</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=images" class="tag-cloud-link tag-link-images tag-link-position-42" style="font-size: 15.058823529412pt;" aria-label="images (1个插件)">images</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=import" class="tag-cloud-link tag-link-import tag-link-position-43" style="font-size: 8.3529411764706pt;" aria-label="import (417个插件)">import</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=javascript" class="tag-cloud-link tag-link-javascript tag-link-position-44" style="font-size: 10.235294117647pt;" aria-label="javascript (606个插件)">javascript</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=jquery" class="tag-cloud-link tag-link-jquery tag-link-position-45" style="font-size: 10.705882352941pt;" aria-label="jquery (666个插件)">jquery</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=link" class="tag-cloud-link tag-link-link tag-link-position-46" style="font-size: 10.235294117647pt;" aria-label="link (606个插件)">link</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=links" class="tag-cloud-link tag-link-links tag-link-position-47" style="font-size: 12.352941176471pt;" aria-label="links (902个插件)">links</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=login" class="tag-cloud-link tag-link-login tag-link-position-48" style="font-size: 13.529411764706pt;" aria-label="login (1个插件)">login</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=marketing" class="tag-cloud-link tag-link-marketing tag-link-position-49" style="font-size: 9.7647058823529pt;" aria-label="marketing (553个插件)">marketing</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=media" class="tag-cloud-link tag-link-media tag-link-position-50" style="font-size: 11.647058823529pt;" aria-label="media (794个插件)">media</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=menu" class="tag-cloud-link tag-link-menu tag-link-position-51" style="font-size: 11.176470588235pt;" aria-label="menu (723个插件)">menu</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=meta" class="tag-cloud-link tag-link-meta tag-link-position-52" style="font-size: 8pt;" aria-label="meta (391个插件)">meta</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=mobile" class="tag-cloud-link tag-link-mobile tag-link-position-53" style="font-size: 9.4117647058824pt;" aria-label="mobile (509个插件)">mobile</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=multisite" class="tag-cloud-link tag-link-multisite tag-link-position-54" style="font-size: 8.1176470588235pt;" aria-label="multisite (394个插件)">multisite</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=navigation" class="tag-cloud-link tag-link-navigation tag-link-position-55" style="font-size: 8.9411764705882pt;" aria-label="navigation (468个插件)">navigation</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=news" class="tag-cloud-link tag-link-news tag-link-position-56" style="font-size: 8.3529411764706pt;" aria-label="news (418个插件)">news</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=newsletter" class="tag-cloud-link tag-link-newsletter tag-link-position-57" style="font-size: 9.0588235294118pt;" aria-label="newsletter (474个插件)">newsletter</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=notification" class="tag-cloud-link tag-link-notification tag-link-position-58" style="font-size: 8.4705882352941pt;" aria-label="notification (421个插件)">notification</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=page" class="tag-cloud-link tag-link-page tag-link-position-59" style="font-size: 13.647058823529pt;" aria-label="page (1个插件)">page</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=pages" class="tag-cloud-link tag-link-pages tag-link-position-60" style="font-size: 11.176470588235pt;" aria-label="pages (729个插件)">pages</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=payment" class="tag-cloud-link tag-link-payment tag-link-position-61" style="font-size: 12.235294117647pt;" aria-label="payment (882个插件)">payment</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=payment+gateway" class="tag-cloud-link tag-link-payment-gateway tag-link-position-62" style="font-size: 11.411764705882pt;" aria-label="payment gateway (763个插件)">payment gateway</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=payments" class="tag-cloud-link tag-link-payments tag-link-position-63" style="font-size: 8.3529411764706pt;" aria-label="payments (415个插件)">payments</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=performance" class="tag-cloud-link tag-link-performance tag-link-position-64" style="font-size: 9.0588235294118pt;" aria-label="performance (480个插件)">performance</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=photo" class="tag-cloud-link tag-link-photo tag-link-position-65" style="font-size: 8.7058823529412pt;" aria-label="photo (450个插件)">photo</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=photos" class="tag-cloud-link tag-link-photos tag-link-position-66" style="font-size: 8.4705882352941pt;" aria-label="photos (426个插件)">photos</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=plugins" class="tag-cloud-link tag-link-plugins tag-link-position-67" style="font-size: 8.1176470588235pt;" aria-label="plugins (398个插件)">plugins</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=popup" class="tag-cloud-link tag-link-popup tag-link-position-68" style="font-size: 9.4117647058824pt;" aria-label="popup (516个插件)">popup</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=post" class="tag-cloud-link tag-link-post tag-link-position-69" style="font-size: 18pt;" aria-label="post (2个插件)">post</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=posts" class="tag-cloud-link tag-link-posts tag-link-position-70" style="font-size: 16.470588235294pt;" aria-label="posts (2个插件)">posts</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=redirect" class="tag-cloud-link tag-link-redirect tag-link-position-71" style="font-size: 8.4705882352941pt;" aria-label="redirect (424个插件)">redirect</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=responsive" class="tag-cloud-link tag-link-responsive tag-link-position-72" style="font-size: 10.117647058824pt;" aria-label="responsive (588个插件)">responsive</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=rss" class="tag-cloud-link tag-link-rss tag-link-position-73" style="font-size: 11.294117647059pt;" aria-label="rss (732个插件)">rss</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=search" class="tag-cloud-link tag-link-search tag-link-position-74" style="font-size: 11.529411764706pt;" aria-label="search (775个插件)">search</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=security" class="tag-cloud-link tag-link-security tag-link-position-75" style="font-size: 13.058823529412pt;" aria-label="security (1个插件)">security</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=seo" class="tag-cloud-link tag-link-seo tag-link-position-76" style="font-size: 15.294117647059pt;" aria-label="seo (1个插件)">seo</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=share" class="tag-cloud-link tag-link-share tag-link-position-77" style="font-size: 10.117647058824pt;" aria-label="share (592个插件)">share</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=shipping" class="tag-cloud-link tag-link-shipping tag-link-position-78" style="font-size: 9.8823529411765pt;" aria-label="shipping (558个插件)">shipping</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=shortcode" class="tag-cloud-link tag-link-shortcode tag-link-position-79" style="font-size: 16.117647058824pt;" aria-label="shortcode (1个插件)">shortcode</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=shortcodes" class="tag-cloud-link tag-link-shortcodes tag-link-position-80" style="font-size: 8.3529411764706pt;" aria-label="shortcodes (412个插件)">shortcodes</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=sidebar" class="tag-cloud-link tag-link-sidebar tag-link-position-81" style="font-size: 14.235294117647pt;" aria-label="sidebar (1个插件)">sidebar</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=slider" class="tag-cloud-link tag-link-slider tag-link-position-82" style="font-size: 12.117647058824pt;" aria-label="slider (866个插件)">slider</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=slideshow" class="tag-cloud-link tag-link-slideshow tag-link-position-83" style="font-size: 8.7058823529412pt;" aria-label="slideshow (449个插件)">slideshow</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=social" class="tag-cloud-link tag-link-social tag-link-position-84" style="font-size: 13.529411764706pt;" aria-label="social (1个插件)">social</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=social+media" class="tag-cloud-link tag-link-social-media tag-link-position-85" style="font-size: 8.5882352941176pt;" aria-label="social media (432个插件)">social media</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=spam" class="tag-cloud-link tag-link-spam tag-link-position-86" style="font-size: 12.117647058824pt;" aria-label="spam (876个插件)">spam</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=statistics" class="tag-cloud-link tag-link-statistics tag-link-position-87" style="font-size: 8.5882352941176pt;" aria-label="statistics (437个插件)">statistics</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=stats" class="tag-cloud-link tag-link-stats tag-link-position-88" style="font-size: 8.7058823529412pt;" aria-label="stats (448个插件)">stats</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=tags" class="tag-cloud-link tag-link-tags tag-link-position-89" style="font-size: 9.4117647058824pt;" aria-label="tags (507个插件)">tags</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=theme" class="tag-cloud-link tag-link-theme tag-link-position-90" style="font-size: 10pt;" aria-label="theme (576个插件)">theme</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=tracking" class="tag-cloud-link tag-link-tracking tag-link-position-91" style="font-size: 8.3529411764706pt;" aria-label="tracking (418个插件)">tracking</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=twitter" class="tag-cloud-link tag-link-twitter tag-link-position-92" style="font-size: 14.941176470588pt;" aria-label="twitter (1个插件)">twitter</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=url" class="tag-cloud-link tag-link-url tag-link-position-93" style="font-size: 8pt;" aria-label="url (386个插件)">url</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=user" class="tag-cloud-link tag-link-user tag-link-position-94" style="font-size: 9.5294117647059pt;" aria-label="user (529个插件)">user</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=users" class="tag-cloud-link tag-link-users tag-link-position-95" style="font-size: 9.4117647058824pt;" aria-label="users (511个插件)">users</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=video" class="tag-cloud-link tag-link-video tag-link-position-96" style="font-size: 12.823529411765pt;" aria-label="video (997个插件)">video</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=widget" class="tag-cloud-link tag-link-widget tag-link-position-97" style="font-size: 20.823529411765pt;" aria-label="widget (4个插件)">widget</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=widgets" class="tag-cloud-link tag-link-widgets tag-link-position-98" style="font-size: 12.588235294118pt;" aria-label="widgets (963个插件)">widgets</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=woocommerce" class="tag-cloud-link tag-link-woocommerce tag-link-position-99" style="font-size: 22pt;" aria-label="woocommerce (6个插件)">woocommerce</a>
            <a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=search&amp;type=tag&amp;s=youtube" class="tag-cloud-link tag-link-youtube tag-link-position-100" style="font-size: 10.470588235294pt;" aria-label="youtube (632个插件)">youtube</a></p><br class="clear"></div>

    <h2>卡片3</h2>
    <div class="the-list" >
        <div class="plugin-card plugin-card-classic-editor">
            <div class="plugin-card-top">
                <div class="name column-name">
                    <h3>
                        <a href="" class="thickbox open-plugin-details-modal">
                            经典编辑器<img src="https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671" class="plugin-icon" alt="">
                        </a>
                    </h3>
                </div>
                <div class="action-links">
                    <ul class="plugin-action-buttons">
                        <li><a class="install-now button" data-slug="classic-editor" href="" aria-label="立即安装经典编辑器 1.6.2" data-name="经典编辑器 1.6.2">立即安装</a></li>
                        <li><a href="https://www.shiguangxiaotou.com/wp-admin/plugin-install.php?tab=plugin-information&amp;plugin=classic-editor&amp;TB_iframe=true&amp;width=772&amp;height=341" class="thickbox open-plugin-details-modal" aria-label="关于经典编辑器 1.6.2的更多信息" data-title="经典编辑器 1.6.2">更多详情</a></li>
                    </ul>
                </div>
                <div class="desc column-description">
                    <p>启用先前版本的 "经典 "编辑器和包含TinyMCE、Meta Boxes等的旧事编辑文章页面。且支持所有扩展此页面的插件。</p>
                    <p class="authors"> <cite>作者：<a href="https://github.com/WordPress/classic-editor/">WordPress Contributors</a></cite></p>
                </div>
            </div>
            <div class="plugin-card-bottom">
                <div class="vers column-rating">
                    <div class="star-rating">
                        <span class="screen-reader-text">5.0星（基于1,119个评级）</span>
                        <div class="star star-full" aria-hidden="true"></div>
                        <div class="star star-full" aria-hidden="true"></div>
                        <div class="star star-full" aria-hidden="true"></div>
                        <div class="star star-full" aria-hidden="true"></div>
                        <div class="star star-full" aria-hidden="true"></div>
                    </div>
                    <span class="num-ratings" aria-hidden="true">(1,119)</span>
                </div>
                <div class="column-updated">
                    <strong>最近更新：</strong>5月前
                </div>
                <div class="column-downloaded">超5百万个已启用安装数</div>
                <div class="column-compatibility">
                    <span class="compatibility-compatible">该插件<strong>兼容</strong>于您当前使用的WordPress版本</span>
                </div>
            </div>
        </div>
    </div>
    <h2>选项卡</h2>

</div>
