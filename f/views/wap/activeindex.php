<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

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

?>
<!--state overview start-->
<div class="row state-overview">

    <section class="panel">
        <div class="weather-bg">
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-group"></i>
                        人才活跃指数
                    </div>
                    <div class="col-xs-6">
                        <div class="degree">
                            赣州
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="panel">
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol terques">
                    <i class="fa fa-user"></i>
                </div>
                <div class="value">
                    <h1 class="count">
                        1000
                    </h1>
                    <p>新流入人数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol red">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="value">
                    <h1 class=" count2">
                        10
                    </h1>
                    <p>人才数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol blue">
                    <i class="fa fa-bar-chart-o"></i>
                </div>
                <div class="value">
                    <h1 class=" count4">
                        0
                    </h1>
                    <p>总活跃数</p>
                </div>
            </section>
        </div>
    </section>
</div>
<!--state overview end-->

<div class="row">

    <div class="col-lg-8">
        <!--work progress start-->
        <section class="panel">
            <div class="panel-body progress-panel">
                <div class="task-progress">
                    <h1>各区县人才活跃指数统计</h1>
                </div>
            </div>
            <table class="table table-hover personal-task">
                <tbody>
                <?
                    foreach ($content as $k => $v) {
                ?>
                        <tr>
                            <td><? echo isset($k) ? $k+1 : '' ?></td>
                            <td>
                                <? echo isset($v['county']) ? $v['county']: '' ?>
                            </td>
                            <td>
                                <span class="badge bg-important"><? echo isset($v['county']) ? $v['onlinecnt'] : '' ?></span>
                            </td>
                            <td>
                                <? if(isset($k)) {$t = $k+1;} else {$k=0;} $id = 'work-progress' . $t; echo "<div id=$id></div>" ?>
                            </td>
                        </tr>
                <?
                    }
                ?>
                </tbody>
            </table>
        </section>
        <!--work progress end-->
    </div>

    <div class="col-lg-4">
        <!--new earning start-->
        <div class="panel terques-chart">
            <div class="panel-body chart-texture">
                <div class="chart">
                    <div class="heading">
                        <span>变化趋势图</span>
                        <strong>57,00 | 45%</strong>
                    </div>
                    <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"></div>
                </div>
            </div>
            <div class="chart-tittle">
                <span class="title">新流入</span>
                              <span class="value">
                                  <a href="#" class="active">在线</a>
                                  |
                                  <a href="#">注册</a>
                                  |
                                  <a href="#">活跃</a>
                              </span>
            </div>
        </div>
        <!--new earning end-->

        <!--total earning start-->
        <div class="panel green-chart">
            <div class="panel-body">
                <div class="chart">
                    <div class="heading">
                        <span>月度数据</span>
                        <strong>30 天 | 65%</strong>
                    </div>
                    <div id="barchart"></div>
                </div>
            </div>
            <div class="chart-tittle">
                <span class="title">总流入数</span>
                <span class="value">7654</span>
            </div>
        </div>
        <!--total earning end-->
    </div>
</div>
