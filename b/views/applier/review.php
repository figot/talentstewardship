<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] =  $this->title;

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?='审核内容'?>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'title',
                                    'applier_name',
                                    'tlevel',
                                    ['label'=>'状态','value'=>Yii::$app->params['talent.statusName'][$model->status]],
                                    'job',
                                    'company',
                                    'content',
                                    'good_fields',
                                    //['attribute'=> '政策落地页预览', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "policy?id={$model->id}", ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                    ['label'=>'发布时间','value'=>date('Y-m-d H:i:s',$model->release_time)],
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

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'status', [
                                'labelOptions' => ['class'=>'col-lg-2 control-label'],
                                'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                            ])->radioList(['1' =>'暂不审核', '2' =>'审核发布', '3'=>'审核不通过'],
                                ['itemOptions'=>['disabled' => $model->status == 2 ? true : false]]) ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?php
                            if ($model->status != 2) {
                                echo Html::submitButton($model->isNewRecord ? Yii::t('common', 'Review') : Yii::t('common', 'Review'), [
                                    'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']);
                            }
                            ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </section>
        </div>

    </div>

</section>