<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = '人才展示审核';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] =  $this->title;

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?='人才评级'?>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'user_name',
                                    'gender',
                                    'id_number',
                                    'pol_visage',
                                    'address',
                                    'email',
                                    'qq',
                                    'wechat',
                                    'brief',
                                    'good_fields',
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'options'=>[
                            'class'=>'form-horizontal'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'category', [
                        'labelOptions' => ['class'=>'col-lg-1 control-label'],
                        'template' => '
                                {label}
                                <div class="col-lg-11">
                                {input}
                                {error}
                                </div>
                                ',
                    ])->dropDownList($levelconf, [
                        'prompt' => '评定人才级别',
                        'class' => 'form-control',
                    ]) ?>


                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?php
                            echo Html::submitButton($model->isNewRecord ? Yii::t('common', 'Review') : Yii::t('common', 'Review'), [
                                'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary'])
                            ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </section>
        </div>

    </div>

</section>