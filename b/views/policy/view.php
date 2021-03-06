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
                                        'attribute' => 'policytype',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.policyType'][$model->policytype];
                                        },
                                        'label' => '政策类型',
                                    ],
                                    ['label'=>'状态','value'=>Yii::$app->params['talent.statusName'][$model->status]],
                                    ['label' => '缩略图', 'format' => ['image', ['width'=>'200', 'height'=>'100']], 'value' => function ($model) {return $model->thumbnail;}],
                                    //['attribute'=> '政策落地页预览', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "policy?id={$model->id}", ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);}, 'format' => 'raw',],
                                    'read_count',
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                    ['label'=>'发布时间','value'=>date('Y-m-d H:i:s',$model->release_time)],
                                    ['attribute'=> '内容预览', 'value' => function ($model) {return HtmlPurifier::process($model->content);}, 'format' => 'raw',],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</section>
