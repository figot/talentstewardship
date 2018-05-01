<?php

use yii\helpers\Html;


$this->title = '更新用户的组织机构';
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