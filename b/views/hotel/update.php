<?php

use yii\helpers\Html;


$this->title = Yii::t('common', 'UpdateHotel');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'levelconf' => $levelconf,
        'areaconf' => $areaconf,
    ]);
    ?>
</section>