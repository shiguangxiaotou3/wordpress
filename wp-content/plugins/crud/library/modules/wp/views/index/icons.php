<?php
/** @var $this yii\web\View */


use crud\modules\wp\models\Icons;
$name = Icons::getIconsNames();
?>
<section>
    <div class="wrap">
        <ul class="flexblock border">
            <?php foreach ($name as $value){ ?>
            <li >
                <h2> <?= Icons::widget($value) ?></h2>
                <?= $value ?>
            </li>
            <?php }?>
        </ul>
    </div>
</section>
