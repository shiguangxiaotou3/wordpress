<?php

use yii\widgets\Menu;
use yii\helpers\Html;
use crud\assets\CrudAsset;
/** @var yii\web\View $this */
/** @var string $content */

$css = <<<CSS
.form-check-label{
margin-left: 25px;
}
CSS;
$this->registerCss($css );
$asset = CrudAsset::register($this);
?>
<div class="wrap">
    <h1 class='wp-heading-inline'>
        Wordpress plugin Crud
        <small>一个可以为你编写代码的神奇工具</small>
    </h1>
    <hr class='wp-header-end' />
    <p >使用以下代码生成器开始游戏:</p>
    <hr style='width: 100%;' />
    <?= $content ?>
    <div class="footer-fix"></div>
</div>