<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = "专属待遇申请";
//$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] =  $this->title;

?>

<section class="wrapper site-min-height">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <?='待遇申请发布审核'?>
                </header>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $welfare,
                                'attributes' => [
                                    'title',
                                    'brief',
                                    ['attribute'=> '待遇内容', 'value' => function ($model) {return HtmlPurifier::process($model->content);}, 'format' => 'raw',],
                                    //['attribute'=> '政策落地页预览', 'value' => function ($model) {return Html::a('落地页跳转',Yii::$app->params['h5urlprefix'] . "policy?id={$model->id}", ['class' => "btn btn-xs btn-info", 'target'=> '_blank']);}, 'format' => 'raw',],
                                    ['label'=>'创建时间','value'=>date('Y-m-d H:i:s',$welfare->created_at)],
                                    ['label'=>'更新时间','value'=>date('Y-m-d H:i:s',$welfare->updated_at)],
                                ],
                                'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?=
                            DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'user_name',
                                    'id_number',
                                    'remark',
                                    'reason',
                                    [
                                        'attribute' => 'applystatus',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.applystatusname2'][$model->applystatus];
                                        },
                                        'label' => '审核状态',
                                    ],
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
                            if (!empty($require)) {
                                foreach ($require as $rk => $rv) {
                                    echo DetailView::widget([
                                        'model' => $rv,
                                        'attributes' => [
                                            //['label'=>'需求申请文件id','value'=> $v['id']],
                                            ['label' => '必选材料', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $rv['imgurl']],
                                        ],
                                        'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                    ]);
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-11">
                            <?
                            if (!empty($optional)) {
                                foreach ($optional as $ok => $ov) {
                                    echo DetailView::widget([
                                        'model' => $ov,
                                        'attributes' => [
                                            //['label'=>'需求申请文件id','value'=> $v['id']],
                                            ['label' => '可选材料', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $ov['imgurl']],
                                        ],
                                        'template' => '<tr><th style="width:15%">{label}</th><td>{value}</td></tr>'
                                    ]);
                                }
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </section>
        </div>

    </div>

</section>