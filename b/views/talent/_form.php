<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$talenttypename = Yii::$app->params['talent.talentShowType'];

?>

<!-- page start-->
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

                <?= $form->field($model, 'category', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
                ])->dropDownList($talenttypename, [
                    'prompt' => '选择人才类别',
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'user_name', [
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

                <?= $form->field($model, 'good_fields', [
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

                <?= $form->field($model, 'isshow', [
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
