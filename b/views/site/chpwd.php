<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var izyue\admin\models\AuthItem $model
 */
$this->title = '修改密码';
?>

<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</section>