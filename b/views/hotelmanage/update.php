<?php

use yii\helpers\Html;

$this->title = "更新酒店管理员配置";

?>
<section class="wrapper site-min-height">
    <?=
    $this->render('_form', [
        'model' => $model,
        'hotel' => $hotel,
        'user' => $user,
    ]);
    ?>
</section>