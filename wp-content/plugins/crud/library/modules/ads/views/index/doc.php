<?php
/** @var $this yii\web\View */
/** @var $myText  */


use yii\helpers\Markdown;
use crud\widgets\PageHeaderWidget;
use crud\widgets\RegisterHighlightAssetWidget;

RegisterHighlightAssetWidget::widget();
?>


<div class="wrap">
    <?= PageHeaderWidget::widget() ?>
    <div id="doc" style="background-color: rgba(220,220,220,0.5);padding: 10px">
        <?=  Markdown::process($myText, 'gfm-comment') ?>
    </div>
</div>
<?php
$css =<<<CSS
#doc img{
    max-width: 100%; height: auto; width: auto; width: auto;
}
CSS;
$this->registerCss($css);