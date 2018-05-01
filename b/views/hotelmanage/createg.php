<?php

use yii\helpers\Html;


$this->title = "新增酒店区域管理员配置";
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_formg', [
        'model' => $model,
        'user' => $user,
        'areaconf' => $areaconf,
    ]);
    ?>
</section>