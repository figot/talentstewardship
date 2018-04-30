<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
use yii\helpers\Url;


$this->title = '项目申请';
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
                                    [
                                        'attribute' => 'remark',
                                        'label' => '备注',
                                    ],
                                    [
                                        'attribute' => 'applystatus',
                                        'value' => function($model){
                                            return Yii::$app->params['talent.applystatusname2'][$model->applystatus];
                                        },
                                        'label' => '申请状态',
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
                            if (!empty($files)) {
                                foreach ($files as $fk => $fv) {
                                    echo DetailView::widget([
                                        'model' => $fv,
                                        'attributes' => [
                                            //['label'=>'需求申请文件id','value'=> $v['id']],
                                            ['label' => '材料', 'format' => ['image', ['width'=>'600', 'height'=>'300']], 'value' => $fv['imgurl']],
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
