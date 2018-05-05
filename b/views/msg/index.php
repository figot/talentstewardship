<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = '消息列表';
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
                            'label' => '消息标题',
                        ],
                        [
                            'attribute' => 'msgtype',
                            'value' => function($model){
                                return Yii::$app->params['talent.msgtype'][$model->msgtype];
                            },
                            'label' => '消息类型',
                        ],
                        [
                            'attribute' => 'area',
                            'label' => '区域',
                        ],
                        [
                            'attribute' => 'department',
                            'label' => '所属部门',
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function($model){
                                return Yii::$app->params['adminuser.msgstatusname'][$model->status];
                            },
                            'label' => '状态',
                        ],
                        [
                            'label'=>'创建时间',
                            'value'=>function($model){
                                return date('Y-m-d H:i:s',$model->created_at);
                            },
                        ],
                        [
                            'label'=>'更新时间',
                            'value'=>function($model) {
                                return date('Y-m-d H:i:s', $model->updated_at);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {delete}',
                            'header' => '操作',
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </section>
    <!-- page end-->
</section>