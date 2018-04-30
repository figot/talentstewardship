<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$policytypename = Yii::$app->params['talent.coopType'];

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

                <?= $form->field($model, 'ctype', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
                ])->dropDownList($policytypename, [
                    'prompt' => '选择项目合作类型',
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'title', [
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

                <?= $form->field($model,'content', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                ])->widget('kucha\ueditor\UEditor',[
                    'clientOptions' => [
                        //编辑区域大小
                        'initialFrameHeight' => '400',
                        //设置语言
                        'lang' =>'zh-cn', //中文为 zh-cn
                    ]
                ]) ?>

<!--                --><?//= $form->field($model, 'content', [
//                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
//                    'template' => '
//                            {label}
//                            <div class="col-lg-10">
//                            {input}
//                            {error}
//                            </div>
//                            ',
//                ])->textarea([
//                    'rows' => 20,
//                    'class' => 'form-control',
//                ]) ?>


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
