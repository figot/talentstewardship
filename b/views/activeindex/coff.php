<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('common', 'Activeindex');

?>
<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?=$this->title?>
                </header>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'options'=>[
                            'class'=>'form-horizontal'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'radix', [
                        'labelOptions' => ['class'=>'col-lg-2 control-label'],
                        'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                    ])->textInput([
                        'maxlength' => 64,
                        'class' => 'form-control',
                    ]) ?>

                    <?= $form->field($model, 'ratio', [
                        'labelOptions' => ['class'=>'col-lg-2 control-label'],
                        'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                    ])->textInput([
                        'maxlength' => 64,
                        'class' => 'form-control',
                    ]) ?>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <?php
                            echo Html::submitButton($model->isNewRecord ? Yii::t('common', 'Save') : Yii::t('common', 'Save'), [
                                'class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger'])
                            ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </div>
</section>