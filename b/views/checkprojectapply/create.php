<?php

use yii\helpers\Html;


$this->title = Yii::t('common', 'CheckprojectApply');

$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'department' => $department,
    ]);
    ?>
</section>