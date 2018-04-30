<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = Yii::t('common', 'Talentshow');
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
                                'model' => $model,
                                'attributes' => [
                                    'user_name',
                                    'mobile',
                                    'gender',
                                    'id_number',
                                    'pol_visage',
                                    'maxdegree',
                                    'address',
                                    'email',
                                    'qq',
                                    'wechat',
                                    'brief',
                                    'good_fields',
                                    'authstatus',
                                    'category',
                                    ['label' => '身份证正面', 'format' => ['image', ['width'=>'400', 'height'=>'200']], 'value' => function ($model) {return "/app/uploads/" . $model->idcardup;}],
                                    ['label' => '身份证反面', 'format' => ['image', ['width'=>'400', 'height'=>'200']], 'value' => function ($model) {return "/app/uploads/" . $model->idcarddown;}],
                                    //'url',
                                    //['attribute'=> '落地页地址', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "project?id={$model->id}", ['target'=> '_blank']);}, 'format' => 'raw',],
                                    //['label'=>'发布时间','value'=>date('Y-m-d H:i:s',$model->release_time)],
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
                                'model' => $education,
                                'attributes' => [
                                    'school',
                                    'institute',
                                    'degree',
                                    'vcode',
                                    'graduation_year',
                                    ['label' => '学位证书', 'format' => ['image', ['width'=>'400', 'height'=>'200']], 'value' => function ($model) {return "/app/uploads/" . $model->certificate;}],
                                    ['label' => '学历证书', 'format' => ['image', ['width'=>'400', 'height'=>'200']], 'value' => function ($model) {return "/app/uploads/" . $model->diploma;}],
                                    //'url',
                                    //['attribute'=> '落地页地址', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "project?id={$model->id}", ['target'=> '_blank']);}, 'format' => 'raw',],
                                    //['label'=>'发布时间','value'=>date('Y-m-d H:i:s',$model->release_time)],
                                ],
                                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            GridView::widget([
                                'dataProvider' => $honor,
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
                                        'attribute' => 'name',
                                        'label' => '姓名',
                                    ],
                                    [
                                        'attribute' => 'year',
                                        'label' => '年份',
                                    ],
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            GridView::widget([
                                'dataProvider' => $exp,
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
                                        'attribute' => 'company',
                                        'label' => '公司',
                                    ],
                                    [
                                        'attribute' => 'industry',
                                        'label' => '行业',
                                    ],
                                    [
                                        'attribute' => 'job',
                                        'label' => '职位',
                                    ],
                                    [
                                        'attribute' => 'jobcontent',
                                        'label' => '工作内容',
                                    ],
                                    [
                                        'attribute' => 'expstart',
                                        'label' => '开始年份',
                                    ],
                                    [
                                        'attribute' => 'expend',
                                        'label' => '结束年份',
                                    ],
                                ],
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</section>
