<?php

use yii\helpers\Html;


$this->title = "设置用户可以管理所属机构";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_formh', [
        'model' => $model,
        'user' => $user,
    ]);
    ?>
</section>