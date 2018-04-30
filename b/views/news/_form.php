<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$newstypename = Yii::$app->params['talent.newsType'];

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

                <?= $form->field($model, 'newstype', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
                ])->dropDownList($newstypename, [
                    'prompt' => '选择资讯类型',
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'can_share', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
                ])->radioList(['1' =>'是', '0'=>'否']) ?>

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

                <?= $form->field($model, 'thumbnail', ['labelOptions' => ['class'=>'col-lg-2 control-label'],])->widget('common\widgets\file_upload\FileUpload',[
                    'config'=>[
                        '图片上传的一些配置，不写调用认配置'
                    ]
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


                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <?php
                        echo Html::submitButton($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Update'), [
                            'class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger'])
                        ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </div>
</div>
