<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ListView;


$this->title = "项目申报申请";
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
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $project,
                                'attributes' => [
                                    [
                                        'attribute' => 'title',
                                        'label' => '项目标题',
                                    ],
                                    [
                                        'attribute' => 'ptype',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.projectType'][$model->ptype];
                                        },
                                        'label' => '申报类型',
                                    ],
                                    [
                                        'attribute' => 'brief',
                                        'label' => '项目简介',
                                    ],
                                    ['label'=>'申请时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $user,
                                'attributes' => [
                                    'user_name',
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'remark',
                                        'label' => '备注',
                                    ],
                                    [
                                        'attribute' => 'applystatus',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.applystatusname2'][$model->applystatus];
                                        },
                                        'label' => '审核状态',
                                    ],
                                    [
                                        'attribute' => 'reason',
                                        'label' => '审核意见',
                                    ],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?
                            if (!empty($require)) {
                                foreach ($require as $rk => $rv) {
                                    echo DetailView::widget([
                                        'model' => $rv,
                                        'attributes' => [
                                            //['label'=>'需求申请文件id','value'=> $v['id']],
                                            ['label' => '必选材料', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $rv['imgurl']],
                                        ],
                                        'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                    ]);
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?
                            if (!empty($optional)) {
                                foreach ($optional as $ok => $ov) {
                                    echo DetailView::widget([
                                        'model' => $ov,
                                        'attributes' => [
                                            //['label'=>'需求申请文件id','value'=> $v['id']],
                                            ['label' => '可选材料', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $ov['imgurl']],
                                        ],
                                        'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                    ]);
                                }
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
                            if ($model->applystatus != 2) {
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