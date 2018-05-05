<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = '消息预览';

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?=$this->title?>
                </header>
                <div class="panel-body">
                    <div class="clearfix">
                        <div class="btn-group">
                            <? if ($model->status == Yii::$app->params['adminuser.msgstatus']['unread']) {
                                echo Html::a('标记消息为已读'.' <i class="fa fa-plus"></i>', ['review', 'id' => $model->id], ['class' => 'btn btn-success', 'style' => 'margin-bottom:15px;']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="space15"></div>
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    ['label'=>'状态','value'=>Yii::$app->params['adminuser.msgstatusname'][$model->status]],
                                    'title',
                                    'content',
                                    [
                                        'label' => '消息类型',
                                        'value' => Yii::$app->params['talent.msgtype'][$model->msgtype],
                                    ],
                                    [
                                        'attribute' => 'area',
                                        'label' => '区域',
                                    ],
                                    [
                                        'attribute' => 'department',
                                        'label' => '所属部门',
                                    ],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$model->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$model->updated_at)],
                                    ['attribute'=> '落地页地址', 'value' => function ($model) {return Html::a('落地页跳转', $model->url, ['target'=> '_blank']);}, 'format' => 'raw',],
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