<?php

use yii\helpers\Html;

$this->title = Yii::t('common', 'Policy');

//$this->title = Yii::t('rbac-admin', 'Update Permission') . ': ' . $model->name;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Permissions'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
//$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Update');
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
    ]);
    ?>
</section>