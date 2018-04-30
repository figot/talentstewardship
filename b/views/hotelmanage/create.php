<?php

use yii\helpers\Html;


$this->title = "新增酒店管理员配置";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_formr', [
        'model' => $model,
        'user' => $user,
    ]);
    ?>
</section>