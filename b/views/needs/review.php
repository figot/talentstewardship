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
                    <div class="clearfix">
                        <div class="btn-group">
                            <?= Html::a('打印为pdf'.' <i class="fa fa-plus"></i>', ['report', 'id' => $model->id], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;', 'target'=> '_blank']) ?>
                        </div>
                    </div>
                    <div class="space15"></div>
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'title',
                                    'content',
                                    'department',
                                    'subdepart',
                                    //['attribute'=> '政策落地页预览', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "policy?id={$model->id}", ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?
                            foreach ($applyfiles as $k => $v) {
                                echo DetailView::widget([
                                    'model' => $v,
                                    'attributes' => [
                                        //['label'=>'需求申请文件id','value'=> $v['id']],
                                        ['label' => '需求申请文件', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $v['imgurl']],
                                    ],
                                    'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                ]);
                            }
                            ?>
                        </div>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'options'=>[
                            'class'=>'form-horizontal'
                        ]
                    ]); ?>

                    <div class="row">
                        <div class="col-md-11">
                            <?= $form->field($model, 'applystatus', [
                                'labelOptions' => ['class'=>'col-lg-2 control-label'],
                                'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                            ])->radioList(['1' =>'暂不审核', '2' =>'审核通过', '3'=>'审核不通过'],
                                ['itemOptions'=>['disabled' => $model->applystatus == 2 ? true : false]]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?= $form->field($model, 'reason', [
                                'labelOptions' => ['class'=>'col-lg-2 control-label'],
                                'template' => '
                            {label}
                            <div class="col-lg-10">
                            {input}
                            {error}
                            </div>
                            ',
                            ])->textarea([
                                'rows' => 2,
                                'class' => 'form-control',
                                'disabled' => $model->applystatus == 2 ? true : false
                            ]) ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?php
                            if ($model->applystatus !== 2) {
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