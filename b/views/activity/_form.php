<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

$acttypename = Yii::$app->params['talent.trainType'];

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

                <?= $form->field($model, 'acttype', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
                ])->dropDownList($acttypename, [
                    'prompt' => '选择交流培训类型',
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

                <?=$form->field($model, 'activity_time', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                ])->widget(DateTimePicker::classname(),[
                    'language' => 'zh-CN',
                    'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
                    'value' => '2018-01-01',
                    'options' => ['class' => 'form-control', 'placeholder' => '选择活动时间'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii',
                        'todayHighlight' => true,
                    ]
                ])?>

                <?= $form->field($model, 'activity_pos', [
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
//                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'department', [
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
//                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'thumbnail', ['labelOptions' => ['class'=>'col-lg-2 control-label'],])->widget('common\widgets\file_upload\FileUpload',[
                    'config'=>[
                        '图片上传的一些配置，不写调用认配置'
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
