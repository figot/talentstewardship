<?php

/* @内容*/

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="site-contact">
    <h1><?= Html::encode($model->platname) ?></h1>

    <div class="username">
        <?= Html::encode($model->content) ?>
    </div>
    <!--    <div class="post">-->
    <!--        --><?//= HtmlPurifier::process($model->content) ?>
    <!--    </div>-->

</div>