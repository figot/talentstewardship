<?php

/* @var $this yii\web\View */

$this->registerCssFile('@web/statics/assets/font-awesome/css/font-awesome.css', ['depends'=>'b\assets\AppAsset']);
$this->registerCssFile('@web/statics/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css', ['depends'=>'b\assets\AppAsset']);
$this->registerCssFile('@web/statics/css/owl.carousel.css', ['depends'=>'b\assets\AppAsset']);

$this->registerJsFile('@web/statics/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/owl.carousel.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/jquery.customSelect.min.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/respond.min.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/sparkline-chart.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/easy-pie-chart.js', ['depends'=>'b\assets\AppAsset']);
$this->registerJsFile('@web/statics/js/count.js', ['depends'=>'b\assets\AppAsset']);

$this->registerJs("
      //owl carousel

      $(document).ready(function() {
          $(\"#owl-demo\").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
			  autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
");

//$this->title = '苏区伯乐人才奖';
?>

<div class="row">
    <section class="panel">
        <div class="flat-carousal">
            <div id="owl-demo" class="owl-carousel owl-theme">
                <div class="item">
                    <h1>苏区人才伯乐奖</h1>
                    <div class="text-center">
                        <a href="javascript:;" class="view-all">敬请期待</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <ul class="ft-link">
                <li class="active">
                    <a href="javascript:;">
                        <i class="fa fa-bars"></i>
                        简介
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class=" fa fa-calendar-o"></i>
                        项目
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class=" fa fa-camera"></i>
                        荣誉
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <i class=" fa fa-circle"></i>
                        贡献
                    </a>
                </li>
            </ul>
        </div>
    </section>
</div>


<div class="row">
    <div class="col-lg-4">
        <!--user info table start-->
        <section class="panel">
            <div class="panel-body">
                <a href="#" class="task-thumb">
                    <img src="<?=Yii::getAlias('@web')?>/statics/img/3361518442231.jpg" alt="">
                </a>
                <div class="task-thumb-details">
                    <h1><a href="#">人才伯乐奖敬请期待</a></h1>
                    <p>擅长领域</p>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>
                        <i class=" fa fa-tasks"></i>
                    </td>
                    <td>简介</td>
                    <td> 02</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-exclamation-triangle"></i>
                    </td>
                    <td>项目</td>
                    <td> 14</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-envelope"></i>
                    </td>
                    <td>荣誉</td>
                    <td> 45</td>
                </tr>
                <tr>
                    <td>
                        <i class=" fa fa-bell-o"></i>
                    </td>
                    <td>贡献</td>
                    <td> 09</td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--user info table end-->
    </div>
    <div class="col-lg-4">
        <!--user info table start-->
        <section class="panel">
            <div class="panel-body">
                <a href="#" class="task-thumb">
                    <img src="<?=Yii::getAlias('@web')?>/statics/img/3361518442231.jpg" alt="">
                </a>
                <div class="task-thumb-details">
                    <h1><a href="#">人才伯乐奖敬请期待</a></h1>
                    <p>擅长领域</p>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>
                        <i class=" fa fa-tasks"></i>
                    </td>
                    <td>简介</td>
                    <td> 02</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-exclamation-triangle"></i>
                    </td>
                    <td>项目</td>
                    <td> 14</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-envelope"></i>
                    </td>
                    <td>荣誉</td>
                    <td> 45</td>
                </tr>
                <tr>
                    <td>
                        <i class=" fa fa-bell-o"></i>
                    </td>
                    <td>贡献</td>
                    <td> 09</td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--user info table end-->
    </div>
    <div class="col-lg-4">
        <!--user info table start-->
        <section class="panel">
            <div class="panel-body">
                <a href="#" class="task-thumb">
                    <img src="<?=Yii::getAlias('@web')?>/statics/img/3361518442231.jpg" alt="">
                </a>
                <div class="task-thumb-details">
                    <h1><a href="#">人才伯乐奖敬请期待</a></h1>
                    <p>擅长领域</p>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>
                        <i class=" fa fa-tasks"></i>
                    </td>
                    <td>简介</td>
                    <td> 02</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-exclamation-triangle"></i>
                    </td>
                    <td>项目</td>
                    <td> 14</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-envelope"></i>
                    </td>
                    <td>荣誉</td>
                    <td> 45</td>
                </tr>
                <tr>
                    <td>
                        <i class=" fa fa-bell-o"></i>
                    </td>
                    <td>贡献</td>
                    <td> 09</td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--user info table end-->
    </div>
    <div class="col-lg-4">
        <!--user info table start-->
        <section class="panel">
            <div class="panel-body">
                <a href="#" class="task-thumb">
                    <img src="<?=Yii::getAlias('@web')?>/statics/img/3361518442231.jpg" alt="">
                </a>
                <div class="task-thumb-details">
                    <h1><a href="#">人才伯乐奖敬请期待</a></h1>
                    <p>擅长领域</p>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>
                        <i class=" fa fa-tasks"></i>
                    </td>
                    <td>简介</td>
                    <td> 02</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-exclamation-triangle"></i>
                    </td>
                    <td>项目</td>
                    <td> 14</td>
                </tr>
                <tr>
                    <td>
                        <i class="fa fa-envelope"></i>
                    </td>
                    <td>荣誉</td>
                    <td> 45</td>
                </tr>
                <tr>
                    <td>
                        <i class=" fa fa-bell-o"></i>
                    </td>
                    <td>贡献</td>
                    <td> 09</td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--user info table end-->
    </div>
    <div class="col-lg-8">
        <!--work progress start-->
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>人才伯乐奖排行榜敬请期待</h1>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        1
                    </td>
                    <td>
                        <span class="badge bg-important">75%</span>
                    </td>
                    <td>
                        <div id="work-progress1"></div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        2
                    </td>
                    <td>
                        <span class="badge bg-success">43%</span>
                    </td>
                    <td>
                        <div id="work-progress2"></div>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        3
                    </td>
                    <td>
                        <span class="badge bg-info">67%</span>
                    </td>
                    <td>
                        <div id="work-progress3"></div>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        4
                    </td>
                    <td>
                        <span class="badge bg-warning">30%</span>
                    </td>
                    <td>
                        <div id="work-progress4"></div>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        5
                    </td>
                    <td>
                        <span class="badge bg-primary">15%</span>
                    </td>
                    <td>
                        <div id="work-progress5"></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
        <!--work progress end-->
    </div>
</div>
