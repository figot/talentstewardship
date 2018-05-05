<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = '酒店详细订单';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?=$this->title?>
                </header>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $hotel,
                                'attributes' => [
                                    [
                                        'attribute'=> 'hotelname',
                                        'label' => '酒店',
                                    ],
                                ],
                                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
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
                                        'attribute' => 'user_name',
                                        'label' => '姓名',
                                    ],
                                    [
                                        'attribute' => 'id_number',
                                        'label' => '身份证号',
                                    ],
                                    [
                                        'attribute' => 'rooms',
                                        'label' => '房间数',
                                    ],
                                    [
                                        'attribute'=> 'chkindt',
                                        'label'=>'签入时间',
                                        'value'=> function($model){
                                            return empty($model->chkindt) ? $model->chkindt : date('Y-m-d H:i:s',$model->chkindt);
                                        },
                                    ],
                                    [
                                        'attribute'=> 'chkoutdt',
                                        'label'=>'签出时间',
                                        'value'=> function($model){
                                            return empty($model->chkoutdt) ? $model->chkoutdt : date('Y-m-d H:i:s',$model->chkoutdt);
                                        },
                                    ],
                                    [
                                        'attribute'=> 'startdt',
                                        'label'=>'入住日期',
                                        'value'=> function($model){
                                            return date('Y-m-d H:i:s',$model->startdt);
                                        },
                                    ],
                                    [
                                        'attribute'=> 'enddt',
                                        'label'=>'离店日期',
                                        'value'=> function($model){
                                            return date('Y-m-d H:i:s',$model->enddt);
                                        },
                                    ],
                                    [
                                        'attribute'=> 'intelvaldate',
                                        'label'=>'入住天数',
                                        'value'=> function($model){
                                            return ceil(abs(strtotime(date('Y-m-d',$model->enddt)) - strtotime(date('Y-m-d',$model->startdt)))) / 86400;
                                        },
                                    ],
                                    [
                                        'attribute'=> 'roomtype',
                                        'label' => '房间类型',
                                    ],
                                    [
                                        'attribute'=> 'rooms',
                                        'label' => '房间数',
                                    ],
                                    [
                                        'attribute'=> 'ischkinbeforedate',
                                        'label' => '是否18点前入住',
                                    ],
                                    [
                                        'attribute'=> 'out_trade_no',
                                        'label' => '订单id',
                                    ],
                                    [
                                        'attribute'=> 'price',
                                        'label' => '金额',
                                    ],
                                    [
                                        'attribute'=> 'hotelcheckstatus',
                                        'label'=>'酒店确认状态',
                                        'value'=> function($model){
                                            return Yii::$app->params['order.hotelcheckstatus'][$model->hotelcheckstatus];
                                        },
                                    ],
                                    [
                                        'attribute'=> 'status',
                                        'label'=>'状态',
                                        'value'=> function($model){
                                            return Yii::$app->params['order.status'][$model->status];
                                        },
                                    ],
                                ],
                                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $talent,
                                'attributes' => [
                                    [
                                        'attribute' => 'authstatus',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.authstatusname'][$model['authstatus']];
                                        },
                                        'label' => '认证状态',
                                    ],
                                    [
                                        'attribute' => 'category',
                                        'label' => '人才级别',
                                    ],
                                    ['label' => '身份证正面', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $talent['idcardupurl']],
                                    ['label' => '身份证反面', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $talent['idcarddownurl']],
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
                                'model' => $education,
                                'attributes' => [
                                    ['label' => '学位证书', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $education['certificateurl']],
                                    ['label' => '学历证书', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $education['diplomaurl']],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</section>
