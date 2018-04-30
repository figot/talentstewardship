<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('common', 'Needslist');
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
                            'attribute' => 'title',
                            'label' => '需求标题',
                        ],
                        [
                            'attribute' => 'department',
                            'label' => '一级部门',
                        ],
                        [
                            'attribute' => 'subdepart',
                            'label' => '二级部门',
                        ],
                        [
                            'attribute' => 'applystatus',
                            'value' => function($model){
                                return Yii::$app->params['talent.statusName'][$model->applystatus];
                            },
                            'label' => '状态',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{review} {view}',
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