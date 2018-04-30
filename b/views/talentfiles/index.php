<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('common', 'TalentFiles');
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
                        <?= Html::a(Yii::t('common', 'Create').' <i class="fa fa-plus"></i>', ['create', 'talentcategoryid' => $talenttemplate->id], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;']) ?>
                    </div>
                </div>
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
                            'attribute'=>'isrequired',
                            'label' => '是否必选',
                        ],
                        [
                            'attribute'=>'templatename',
                            'label' => '模板名称',
                        ],
                        [
                            'attribute'=>'filetemplateurl',
                            'label' => '文件模板预览',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('文件模板预览',Yii::$app->params['hostname'] . "{$model->filetemplateurl}", ['target'=> '_blank','class' => "btn btn-xs btn-info"]);
                            }
                        ],
                        [
                            'attribute' => 'updated_at',
                            'value' => function($model){
                                return date('Y-m-d H:i:s',$model->updated_at);
                            },
                            'label'=>'更新时间',
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{review} {update} {delete}',
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