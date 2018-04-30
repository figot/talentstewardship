<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;


$this->title = '上传以及删除酒店图片';
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
                                    'attribute' => 'imageurl',
                                    'label' => '酒店图片',
                                    'format' => ['image', ['width'=>'200', 'height'=>'100']],
                                    'value' => function ($model) {
                                        return $model->imageurl;
                                    }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '{deleteimage}',
                                    'header' => '操作',
                                    'buttons' => [
                                        'deleteimage' => function ($url, $model, $key) {
                                            return Html::a('<span class="glyphicon glyphicon-trash">删除照片</span>', $url, ['data-method' => 'post','data-pjax'=>'0'] );
                                        },
                                    ],
                                ],
                            ],
                        ])
                        ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin([
                        'options'=>[
                            'class'=>'form-horizontal'
                        ]
                    ]); ?>

                    <?= $form->field($model, 'imageurl')->widget('common\widgets\batch_upload\FileUpload')
                    ?>


                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <?php
                            echo Html::submitButton($model->isNewRecord ? Yii::t('common', 'Save') : Yii::t('common', 'Save'), [
                                'class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger'])
                            ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </div>
</section>
