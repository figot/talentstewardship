<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class = "images">
    <?= $model->id ?>
    <?= Html::encode($model->name) ?>
    <?= HtmlPurifier::process($model->email) ?>
</div>