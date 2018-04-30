<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = "人才认证申请审核";
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
                                    [
                                        'attribute' => 'remark',
                                        'label' => '备注',
                                    ],
                                    [
                                        'attribute' => 'applystatus',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.authstatusname'][$model->applystatus];
                                        },
                                        'label' => '申请状态',
                                    ],
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
                            <?=
                            DetailView::widget([
                                'model' => $user,
                                'attributes' => [
                                    'user_name',
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
                            ])->radioList(['2' =>'暂不审核', '4'=>'人才认证审核通过', '3' =>'人才认证审核不通过'],
                                ['itemOptions'=>['disabled' => $model->applystatus == Yii::$app->params['talent.authstatus']['authsuccess'] ? true : false]]) ?>
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
                                'disabled' => $model->applystatus == Yii::$app->params['talent.authstatus']['authsuccess'] ? true : false,
                            ]) ?>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-lg-offset-1 col-lg-11">
                            <?php
                            if ($model->applystatus != Yii::$app->params['talent.authstatus']['authsuccess']) {
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