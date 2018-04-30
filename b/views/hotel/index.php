<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('common', 'Hotel');
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
                <div class="clearfix">
                    <div class="btn-group">
                        <?= Html::a(Yii::t('common', 'Create').' <i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;']) ?>
                    </div>
                </div>
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
                            'attribute' => 'hotelname',
                            'label' => '酒店名称',
                        ],
                        [
                            'attribute' => 'area',
                            'label' => '区域',
                        ],
                        [
                            'attribute'=>'qrurl',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('生成酒店签入签出二维码',['hotel/qrcode', 'id' => $model->id], ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);
                            }
                        ],
                        [
                            'attribute'=>'rooms',
                            'label' => '酒店房间',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('酒店房间',['room/index', 'hotelid' => $model->id], ['class' => "btn btn-xs btn-info"]);
                            }
                        ],
                        [
                            'attribute'=>'orders',
                            'label' => '酒店订单',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('酒店订单',['hotelorder/index', 'hotelid' => $model->id], ['class' => "btn btn-xs btn-info"]);
                            }
                        ],
                        [
                            'attribute'=>'images',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('上传酒店图片',['hotel/images', 'id' => $model->id], ['class' => "btn btn-xs btn-info"]);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($model){
                                return Yii::$app->params['talent.statusName'][$model->status];
                            },
                            'label' => '状态',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{review} {view} {update} {delete}',
                            'header' => '操作',
                            'buttons' => [
                                'review' => function ($url, $model, $key) {
                                    return Html::a('<span class="glyphicon glyphicon-check">审核</span>', $url, ['data-method' => 'post','data-pjax'=>'0'] );
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