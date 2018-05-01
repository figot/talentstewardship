<?php

use yii\helpers\Html;


$this->title = '设置用户所属机构';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'department' => $department,
        'user' => $user,
    ]);
    ?>
</section>