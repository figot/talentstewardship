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

    <h2 class="form-signin-heading">企业注册</h2>
    <div class="login-wrap">
        <p>输入企业信息</p>
        <?= $form->field($model, 'companyname',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "公司注册备案名称", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($model, 'address',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "地址", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>

        <?= $form->field($model, 'mobile',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "邮箱", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {input}
                            </div>',
        ])->label(false) ?>


        <p> 输入注册信息</p>
        <?= $form->field($model, 'companyname',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "登录名", 'autofocus' => true],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
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

        <?= $form->field($model, 'repeatpassword',[
            'inputOptions' => ['class'=>'form-control', 'placeholder' => "重复输入密码"],
            'inputTemplate' => '<div class="input-group m-bot15">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                {input}
                            </div>',
        ])->passwordInput()->label(false) ?>

        <label class="checkbox">
            <input type="checkbox" value="agree this condition"> 我同意服务条款和隐私政策
        </label>
        <button class="btn btn-lg btn-login btn-block" type="submit">Submit</button>

        <div class="registration">
            仍然注册.
            <a class="" href="<?= Url::to('companysignin')?>">
                登录
            </a>
        </div>

    </div>

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

        <a href="<?= Url::to('companysignin')?>">
            <div>
                <span class="pull-right"><i class="fa fa-sign-in fa-fw"></i>企业注册</span>
            </div>
        </a>

        <?= Html::submitButton(Yii::t('common', 'login'), ['class' => 'btn btn-lg btn-login btn-block', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>


<div class="nav notify-row" id="top_menu">
    <!--  notification start -->
    <ul class="nav top-menu">
        <!-- settings start -->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-tasks"></i>
                <span class="badge bg-success">2</span>
            </a>
            <ul class="dropdown-menu extended tasks-bar">
                <div class="notify-arrow notify-arrow-green"></div>
                <li>
                    <p class="green">2个待处理任务</p>
                </li>
                <li>
                    <a href="#">
                        <div class="task-info">
                            <div class="desc">任务进度</div>
                            <div class="percent">40%</div>
                        </div>
                        <div class="progress progress-striped">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                <span class="sr-only">40% Complete (success)</span>
                            </div>
                        </div>
                    </a>
                </li>
                <li class="external">
                    <a href="#">所有任务</a>
                </li>
            </ul>
        </li>
        <!-- settings end -->
        <!-- inbox dropdown start-->
        <li id="header_inbox_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-envelope-o"></i>
                <span class="badge bg-important">3</span>
            </a>
            <ul class="dropdown-menu extended inbox">
                <div class="notify-arrow notify-arrow-red"></div>
                <li>
                    <p class="red">3条新信息</p>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="<?=Yii::getAlias('@web')?>/statics/img/avatar-mini.jpg"></span>
                                    <span class="subject">
                                    <span class="from">测试</span>
                                    <span class="time">刚刚</span>
                                    </span>
                                    <span class="message">
                                        测试消息
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="<?=Yii::getAlias('@web')?>/statics/img/avatar-mini2.jpg"></span>
                                    <span class="subject">
                                    <span class="from">测试</span>
                                    <span class="time">10 分钟</span>
                                    </span>
                                    <span class="message">
                                     测试消息
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="photo"><img alt="avatar" src="<?=Yii::getAlias('@web')?>/statics/img/avatar-mini3.jpg"></span>
                                    <span class="subject">
                                    <span class="from">测试</span>
                                    <span class="time">3 小时</span>
                                    </span>
                                    <span class="message">
                                        测试消息
                                    </span>
                    </a>
                </li>
                <li>
                    <a href="#">所有消息</a>
                </li>
            </ul>
        </li>
        <!-- inbox dropdown end -->
        <!-- notification dropdown start-->
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                <i class="fa fa-bell-o"></i>
                <span class="badge bg-warning">7</span>
            </a>
            <ul class="dropdown-menu extended notification">
                <div class="notify-arrow notify-arrow-yellow"></div>
                <li>
                    <p class="yellow">7条通知</p>
                </li>
                <li>
                    <a href="#">
                        <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                        通知
                        <span class="small italic">34 分钟</span>
                    </a>
                </li>
                <li>
                    <a href="#">所有通知</a>
                </li>
            </ul>
        </li>
        <!-- notification dropdown end -->
    </ul>
    <!--  notification end -->
</div>
