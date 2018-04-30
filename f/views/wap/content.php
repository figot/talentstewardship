<?php

/* @内容*/

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="site-contact">
    <h3 class="customtitle"><?= Html::encode($model->title) ?></h3>

    <h3></h3>

    <div class="post">
        <?= HtmlPurifier::process($model->content) ?>
    </div>

</div>
