<?php

use yii\widgets\Menu;
use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

$asset = crud\modules\gii\GiiAsset::register($this);
?>
<div class="wrap">
    <div class="page-container">
        <div >
            <?= $content ?>
        </div>
        <div class="footer-fix"></div>
    </div>
</div>
<?php

$css =<<<CSS
.form-check-label {
 margin-left: 20px;
}
CSS;
$this->registerCss($css);
