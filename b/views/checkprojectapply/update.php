<?php

use yii\helpers\Html;

$this->title = Yii::t('common', 'Checkproject');
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'department' => $department,
    ]);
    ?>
</section>