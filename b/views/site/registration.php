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
        'class'=>'form-signup form-signin lock-box text-center'
    ]
]); ?>

    <h2 class="form-signin-heading">企业注册</h2>
    <div class="login-wrap">
        <p> 输入注册信息</p>
        <?= $form->field($model, 'username',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "登录名", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($model, 'email',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "邮箱", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($model, 'password',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "密码"],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                {input}
                            </div>',
        ])->passwordInput()->label(false) ?>

        <?= $form->field($model, 'passwordrepeat',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "重复输入密码"],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                {input}
                            </div>',
        ])->passwordInput()->label(false) ?>

        <?= $form->field($company, 'companyname',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "公司注册备案名称", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-magnet"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($company, 'address',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "地址", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($company, 'taxno',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "税号", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($company, 'mobile',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "电话", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-mobile-phone"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <div class="row">
            <?= $form->field($company, 'business_license', ['labelOptions' => ['class'=>'col-lg-1 control-label'],])->widget('common\widgets\pic_upload\FileUpload',[
                'config'=>[
                    '图片上传的一些配置，不写调用认配置'
                ]
            ]) ?>
        </div>
        <label class="checkbox">
            <input type="checkbox" value="agree this condition"> 我同意服务条款和隐私政策
        </label>
<!--        <button class="btn btn-lg btn-login btn-block" type="submit">注册</button>-->
        <?= Html::submitButton('注册', ['class' => 'btn btn-lg btn-login btn-block', 'name' => 'registration-button']) ?>

        <div class="registration">
            仍然注册.
            <a class="" href="<?= Url::to('login')?>">
                 登录
            </a>
        </div>

    </div>
<?php ActiveForm::end(); ?>