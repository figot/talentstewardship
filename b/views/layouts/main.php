<?php

/* @var $this \yii\web\View */
/* @var $content string */

use b\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use izyue\admin\components\MenuHelper;

AppAsset::register($this);

$menuRows = MenuHelper::getAssignedMenu(Yii::$app->user->id);

$route = Yii::$app->controller->getRoute();
$routeArray = explode('/', $route);
array_pop($routeArray);
$controllerName = implode('/', $routeArray);

$this->registerCssFile('@web/statics/css/slidebars.css', ['depends'=>'b\assets\AppAsset']);

function isSubUrl($menuArray, $route)
{

    if (isset($menuArray) && is_array($menuArray)) {

        if (isset($menuArray['items'])) {
            foreach ($menuArray['items'] as $item)
            {
                if (isSubUrl($item, $route)) {
                    return true;
                }
            }
        } else {
            $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
            if (strpos($url, $route)) {
                return true;
            }
        }
    } else {
        $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
        if (strpos($url, $route)) {
            return true;
        }
    }
    return false;

}

function isSubMenu($menuArray, $controllerName)
{

    if (isset($menuArray) && is_array($menuArray)) {

        if (isset($menuArray['items'])) {
            foreach ($menuArray['items'] as $item)
            {
                if (isSubMenu($item, $controllerName)) {
                    return true;
                }
            }
        } else {
            $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
            if (strpos($url, $controllerName.'/')) {
                return true;
            }
        }
    } else {
        $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];
        if (strpos($url, $controllerName.'/')) {
            return true;
        }
    }
    return false;

}



function initMenu($menuArray, $controllerName, $isSubUrl, $isShowIcon=false)
{
    if (isset($menuArray) && is_array($menuArray)) {

        $url = is_array($menuArray['url']) ? $menuArray['url'][0] : $menuArray['url'];

        if (empty($isSubUrl)) {
            $isSubMenu = isSubMenu($menuArray, $controllerName);
        } else {
            $route = Yii::$app->controller->getRoute();
            $isSubMenu = isSubUrl($menuArray, $route);
        }
        if ($isSubMenu) {
            $class = ' active ';
        } else {
            $class = '';
        }

        if (isset($menuArray['items'])) {
            echo '<li class="sub-menu">';
        } else {
            echo '<li class="'.$class.'">';
        }
        $url = $url == '#' ? 'javascript:;' : Url::toRoute($url);
        echo '<a href="'.$url.'"  class="'.$class.'">'.($isShowIcon ? '<i class="fa fa-sitemap"></i>' : '').'<span>'.$menuArray['label'].'</span></a>';

        if (isset($menuArray['items'])) {
            echo '<ul class="sub">';
            foreach ($menuArray['items'] as $item)
            {
                echo initMenu($item, $controllerName, $isSubUrl);
            }
            echo '</ul>';
        }

        echo '</li>';
    }

}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<section id="container" >
    <!--header start-->
    <header class="header white-bg">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        <a href="<?=Url::home()?>" class="logo">赣州市人才管家<span>后台系统</span></a>
        <!--logo end-->
        <div class="top-nav ">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder="Search">
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="" src="<?=Yii::getAlias('@web')?>/statics/img/avatar1_small.jpg">
                        <span class="username"><?=Yii::$app->user->identity['username']?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="#"><i class=" fa fa-suitcase"></i>简介</a></li>
                        <li><a href="<?=Url::toRoute('/site/chpwd')?>" data-method="post"><i class="fa fa-cog"></i> 修改密码</a></li>
                        <li><a href="#"><i class="fa fa-bell-o"></i> 通知</a></li>
                        <li><a href="<?=Url::toRoute('/site/logout')?>" data-method="post"><i class="fa fa-key"></i> 退出登录</a></li>
                    </ul>
                </li>
                <li class="sb-toggle-right">
                    <i class="fa  fa-align-right"></i>
                </li>
                <!-- user login dropdown end -->
            </ul>
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="<?=($controllerName == 'site' ? 'active' : '')?>" href="<?=Url::home()?>">
                        <i class="fa fa-dashboard"></i>
                        <span><?=Yii::t('admin', 'dashboard')?></span>
                    </a>
                </li>
                <?php
                    if(isset($menuRows)){

                        $isSubUrl = false;
                        foreach($menuRows as $menuRow){

                            $isSubUrl = isSubUrl($menuRow, $route);

                            if ($isSubUrl) {
                                break;
                            }


                        }
                        foreach($menuRows as $menuRow){
                            initMenu($menuRow, $controllerName, $isSubUrl, true);
                        }
                    }
                ?>

            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <?=$content?>
    </section>
    <!--main content end-->

    <!-- Right Slidebar start -->
<!--    <div class="sb-slidebar sb-right sb-style-overlay">-->
<!--        <h5 class="side-title">测试</h5>-->
<!--        <ul class="quick-chat-list">-->
<!--            <li class="online">-->
<!--                <div class="media">-->
<!--                    <a href="#" class="pull-left media-thumb">-->
<!--                        <img alt="" src="--><?//=Yii::getAlias('@web')?><!--/statics/img/chat-avatar2.jpg" class="media-object">-->
<!--                    </a>-->
<!--                    <div class="media-body">-->
<!--                        <strong>admin</strong>-->
<!--                        <small>admin</small>-->
<!--                    </div>-->
<!--                </div><!-- media -->-->
<!--            </li>-->
<!--        </ul>-->
<!--        <h5 class="side-title"> 任务</h5>-->
<!--        <ul class="p-task tasks-bar">-->
<!--            <li>-->
<!--                <a href="#">-->
<!--                    <div class="task-info">-->
<!--                        <div class="desc">进度</div>-->
<!--                        <div class="percent">40%</div>-->
<!--                    </div>-->
<!--                    <div class="progress progress-striped">-->
<!--                        <div style="width: 40%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" role="progressbar" class="progress-bar progress-bar-success">-->
<!--                            <span class="sr-only">40% Complete (success)</span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="external">-->
<!--                <a href="#">所有任务</a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
    <!-- Right Slidebar end -->

    <!--footer start-->
<!--    <footer class="site-footer">-->
<!--        <div class="text-center">-->
<!--            2017 &copy; 人才管家后端系统.-->
<!--            <a href="#" class="go-top">-->
<!--                <i class="fa fa-angle-up"></i>-->
<!--            </a>-->
<!--        </div>-->
<!--    </footer>-->
    <!--footer end-->
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
