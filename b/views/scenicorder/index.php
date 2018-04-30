<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('common', 'Scenicorder');
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
                <div class="space15"></div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
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
                            'attribute' => 'user_id',
                            'label' => '用户',
                        ],
                        [
                            'attribute' => 'chkindt',
                            'value' => function($model){
                                return date('Y-m-d H:i:s',$model->chkindt);
                            },
                            'label' => '签入时间',
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
                            'template' => '{review}',
                            'header' => '操作',
                            'buttons' => [
                                'review' => function ($url, $model, $key) {
                                    //$url = Url::to(['/room/review', 'id'=>$model->id, 'hotelid' => ]);
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