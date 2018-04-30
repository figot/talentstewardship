<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('common', 'Rencaiguanjia');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options'=>[
        'class'=>'form-signin lock-box text-center'
    ]
]); ?>

<a class="logo floatless" href="/">赣州市<span>人才管家</span>系统</a>
<div class="login-wrap">

    <?= $form->field($model, 'username',[
        'inputOptions' => ['class'=>'form-control', 'placeholder' => Yii::t('common', 'username')],
        'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {input}
                            </div>',
    ])->label(false) ?>
    <?= $form->field($model, 'password',[
        'inputOptions' => ['class'=>'form-control', 'placeholder' => Yii::t('common', 'password')],
        'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                {input}
                            </div>',
    ])->passwordInput()->label(false) ?>

    <?= $form->field($model, 'rememberMe',[
        'inputTemplate'=>'{input}',
        'options' => [
        ],
    ])->checkbox() ?>

<!--    --><?//= Html::a('企业注册', ['company/register'], ['class' => 'profile-link']) ?>

    <a href="<?= Url::to('registration')?>">
        <div>
            <span class="pull-right"><i class="fa fa-sign-in fa-fw"></i>企业注册</span>
        </div>
    </a>

    <?= Html::submitButton(Yii::t('common', 'login'), ['class' => 'btn btn-lg btn-login btn-block', 'name' => 'login-button']) ?>
</div>
<?php ActiveForm::end(); ?>

