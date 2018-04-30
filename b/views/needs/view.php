<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] =  $this->title;

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?='审核内容'?>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'title',
                                    'content',
                                    'department',
                                    'subdepart',
                                    ['label'=>'审核状态','value'=>Yii::$app->params['talent.statusName'][$model->applystatus]],
                                    'reason',
                                    //['attribute'=> '政策落地页预览', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "policy?id={$model->id}", ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-11">
                            <?
                            foreach ($applyfiles as $k => $v) {
                                echo DetailView::widget([
                                    'model' => $v,
                                    'attributes' => [
                                        //['label'=>'需求申请文件id','value'=> $v['id']],
                                        ['label' => '需求申请文件', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $v['imgurl']],
                                    ],
                                    'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

</section>