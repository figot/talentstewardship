<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = $model->title;
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
                                    'title',
                                    [
                                        'attribute' => 'status',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.statusName'][$model->status];
                                        },
                                        'label' => '状态',
                                    ],
                                    [
                                        'attribute' => 'treattype',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.treattype'][$model->treattype];
                                        },
                                        'label' => '享受类别',
                                    ],
                                    //['label' => '缩略图', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => function ($model) {return $model->thumbnail;}],
                                    //['attribute'=> '落地页地址', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "scenic?id={$model->id}", ['target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                    ['attribute'=> '待遇简介', 'value' => function ($model) {return HtmlPurifier::process($model->brief);}, 'format' => 'raw',],
                                    ['attribute'=> '待遇详细', 'value' => function ($model) {return HtmlPurifier::process($model->content);}, 'format' => 'raw',],
                                ],
                                'template' => '<tr><th style="width:25%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</section>
