<?php

/* @内容*/

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\HtmlPurifier;

?>

<div class="row">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'options'=>['HeaderStyle-Wrap'=>true,],
        'tableOptions' => [
            'class' => 'table table-striped table-hover',
            'id' => 'editable-sample',
        ],
        'layout'=> '{items}
                    <div class="row">
                          <div class="col-lg-6">
                               <div class="dataTables_paginate paging_bootstrap pagination">{pager}</div>
                          </div>
                    </div>',
        'caption' => '',
        'captionOptions' => ['style' => 'font-size: 20px; font-weight: bold; color: #000; text-align: center;'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
            ],
            [
                'attribute'=>'title',
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
                'label' => '标题',
                'encodeLabel' => false,
                'format' => 'raw',
                'value' => function($model){
                    return Html::a($model['title'],['wap/help', 'id' => $model->id]);
                }
            ],
            [
                'attribute'=>'title',
                'headerOptions' => [
                    'style' => 'display: none;',
                ],
                'label' => '标题',
                'format' => 'raw',
                'contentOptions' => ['style'=>'padding:15px 15px 15px 15px;vertical-align: middle;'],
                'value' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-chevron-right"></span>', ['wap/help', 'id' => $model->id]);
                }
            ],
        ],
    ])
    ?>
</div>