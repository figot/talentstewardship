<?php

/* @内容*/

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="site-contact">
    <h2><?= Html::encode($model->name) ?></h2>

    <h3></h3>

    <!--    <div class="username">-->
    <!--        --><?//= Html::encode($model->content) ?>
    <!--    </div>-->
    <div class="post">
        <?= HtmlPurifier::process($model->content) ?>
    </div>

</div>
