<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = Yii::t('common', 'Rencaiguanjia');
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
                                    ['label'=>'状态','value'=>Yii::$app->params['talent.statusName'][$model->status]],
                                    'title',
                                    ['label' => '缩略图', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => function ($model) {return $model->thumbnail;}],
                                    ['attribute'=> '落地页地址', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "activity?id={$model->id}", ['target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'发布时间','value'=>date('Y-m-d H:i:s',$model->release_time)],
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
