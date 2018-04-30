<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('common', 'Order');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/statics/assets/data-tables/DT_bootstrap.css', ['depends'=>'b\assets\AppAsset']);

?>

<section class="wrapper site-min-height">
    <!-- page start-->
    <section class="panel">
        <header class="panel-heading">
            <?=$this->title?>
        </header>
        <div class="panel-body">
            <div class="adv-table editable-table ">
<!--                <div class="clearfix">-->
<!--                    <div class="btn-group">-->
<!--                        --><?//= Html::a(Yii::t('common', 'Create').' <i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;']) ?>
<!--                    </div>-->
<!--                </div>-->
                <div class="space15"></div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => [
                        'class' => 'table table-striped table-hover table-bordered',
                        'id' => 'editable-sample',
                    ],
                    'pager' => [
                        'prevPageLabel' => Yii::t('common', 'Prev'),
                        'nextPageLabel' => Yii::t('common', 'Next'),
                    ],
                    'layout'=> '{items}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="dataTables_info" id="editable-sample_info">{summary}</div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="dataTables_paginate paging_bootstrap pagination">{pager}</div>
                                    </div>
                                </div>',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'user_name',
                            'label' => '姓名',
                        ],
                        [
                            'attribute' => 'id_number',
                            'label' => '身份证号',
                        ],
                        [
                            'label'=>'申请时间',
                            'value'=>function($model) {
                                return date('Y-m-d H:i:s', $model->created_at);
                            }
                        ],
                        [
                            'attribute' => 'rooms',
                            'label' => '房间数',
                        ],
                        [
                            'attribute'=> 'roomtype',
                            'label' => '房间类型',
                        ],
                        [
                            'attribute'=> 'hotelcheckstatus',
                            'label' => '酒店是否确认',
                            'value'=> function($model){
                                return Yii::$app->params['order.hotelcheckstatus'][$model->hotelcheckstatus];
                            },
                        ],
                        [
                            'attribute'=> 'status',
                            'label'=>'入住状态',
                            'value'=> function($model){
                                return Yii::$app->params['order.status'][$model->status];
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{review} {checkin} {checkout} {view}',
                            'header' => '操作',
                            'buttons' => [
                                'review' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-check">申请确认</span>', $url, ['data-method' => 'post','data-pjax'=>'0'] );
                                },
                                'checkin' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-check">入住确认</span>', $url, ['data-method' => 'post','data-pjax'=>'0'] );
                                },
                                'checkout' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-check">离店确认</span>', $url, ['data-method' => 'post','data-pjax'=>'0'] );
                                },
                            ],
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </section>
    <!-- page end-->
</section>