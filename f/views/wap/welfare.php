<?php

/* @内容*/

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<div class="site-contact">
    <h1><?= Html::encode($title) ?></h1>

    <?php $this->beginBody() ?>
    <p class="container-fluid">
        <p class="row-fluid">
            <h4><?= Html::encode($content[0]) ?></h4>

            <p class="bg-success">
                <h4><?= Html::encode($content[1]) ?></h4>
            </p>
            <p class="bg-info">
                <h4><?= Html::encode($content[2]) ?></h4>
            </p>
            <p class="bg-warning">
                <h4><?= Html::encode($content[3]) ?></h4>
            </p>
            <p class="bg-danger">
                <h4><?= Html::encode($content[4]) ?></h4>
            </p>
            <p class="bg-success">
                <h4><?= Html::encode($content[5]) ?></h4>
            </p>
            <p class="bg-primary">
                <h4><?= Html::encode($content[6]) ?></h4>
            </p>
            <p class="bg-info">
                <h4><?= Html::encode($content[7]) ?></h4>
            </p>
            <p class="bg-warning">
                <h4><?= Html::encode($content[8]) ?></h4>
            </p>
        </p>
    </div>

    <?php $this->endBody() ?>

</div>
