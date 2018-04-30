<?php
namespace f\controllers;

use f\models\Scenic;
use f\models\Vipchannel;
use f\models\Activeindex;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use f\models\Policy;
use f\models\Recruit;
use f\models\Applier;
use f\models\Project;
use f\models\Cooperation;
use f\models\Ad;
use f\models\Activity;
use f\models\Devtrends;
use f\models\Devplat;
use f\models\Deviceshare;
use f\models\News;
use f\models\Demand;
use f\models\Welfare;
use mrk\AliPayH5;
use f\models\Help;

/**
 * h5页面
 */
class WapController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     *
     * @return 广告内容h5
     */
    public function actionAd()
    {
        $ad = new Ad();
        if (\Yii::$app->request->isPost) {
            $ad->load(\Yii::$app->request->post(), '');
        } else {
            $ad->load(\Yii::$app->request->get(), '');
        }
        if ($ad->validate()) {
            $model = Ad::find()->select(['title', 'content'])->where(['id' => $ad->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     *
     * @return 政策内容h5
     */
    public function actionPolicy()
    {
        $policy = new Policy();
        if (\Yii::$app->request->isPost) {
            $policy->load(\Yii::$app->request->post(), '');
        } else {
            $policy->load(\Yii::$app->request->get(), '');
        }
        if ($policy->validate()) {
            $model = Policy::find()->select(['title', 'content', 'read_count', 'id'])->where(['id' => $policy->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                $model->read_count = intval($model->read_count) + 1;
                $model->update(false);
            }
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 招聘详细内容
     */
    public function actionRecruit()
    {
        $recruit = new Recruit();
        if (\Yii::$app->request->isPost) {
            $recruit->load(\Yii::$app->request->post(), '');
        } else {
            $recruit->load(\Yii::$app->request->get(), '');
        }
        if ($recruit->validate()) {
            $model = Recruit::find()->select(['title', 'content'])->where(['id' => $recruit->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 招聘详细内容
     */
    public function actionApplier()
    {
        $applier = new Applier();
        if (\Yii::$app->request->isPost) {
            $applier->load(\Yii::$app->request->post(), '');
        } else {
            $applier->load(\Yii::$app->request->get(), '');
        }
        if ($applier->validate()) {
            $model = Applier::find()->select(['title', 'content'])->where(['id' => $applier->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 申报中心详细内容
     */
    public function actionProject()
    {
        $project = new Project();
        if (\Yii::$app->request->isPost) {
            $project->load(\Yii::$app->request->post(), '');
        } else {
            $project->load(\Yii::$app->request->get(), '');
        }
        if ($project->validate()) {
            $model = Project::find()->select(['title', 'content'])->where(['id' => $project->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 项目合作详细内容
     */
    public function actionCoop()
    {
        $coop = new Cooperation();
        if (\Yii::$app->request->isPost) {
            $coop->load(\Yii::$app->request->post(), '');
        } else {
            $coop->load(\Yii::$app->request->get(), '');
        }
        if ($coop->validate()) {
            $model = Cooperation::find()->select(['title', 'content'])->where(['id' => $coop->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 科研动态详细内容
     */
    public function actionDevtrends()
    {
        $coop = new Devtrends();
        if (\Yii::$app->request->isPost) {
            $coop->load(\Yii::$app->request->post(), '');
        } else {
            $coop->load(\Yii::$app->request->get(), '');
        }
        if ($coop->validate()) {
            $model = Devtrends::find()->select(['title', 'content'])->where(['id' => $coop->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 科研平台详细内容
     */
    public function actionDevplat()
    {
        $devplat = new Devplat();
        if (\Yii::$app->request->isPost) {
            $devplat->load(\Yii::$app->request->post(), '');
        } else {
            $devplat->load(\Yii::$app->request->get(), '');
        }
        if ($devplat->validate()) {
            $model = Devplat::find()->select(['platname', 'content'])->where(['id' => $devplat->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('devplat', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 设备共享详细内容
     */
    public function actionDeviceshare()
    {
        $devplat = new Deviceshare();
        if (\Yii::$app->request->isPost) {
            $devplat->load(\Yii::$app->request->post(), '');
        } else {
            $devplat->load(\Yii::$app->request->get(), '');
        }
        if ($devplat->validate()) {
            $model = Deviceshare::find()->select(['devicename', 'content'])->where(['id' => $devplat->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('device', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 项目合作详细内容
     */
    public function actionActivity()
    {
        $act = new Activity();
        if (\Yii::$app->request->isPost) {
            $act->load(\Yii::$app->request->post(), '');
        } else {
            $act->load(\Yii::$app->request->get(), '');
        }
        if ($act->validate()) {
            $model = Activity::find()->select(['title', 'content'])->where(['id' => $act->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     *
     * @return 项目合作详细内容
     */
    public function actionDemandinfo()
    {
        $demand = new Demand();
        if (\Yii::$app->request->isPost) {
            $demand->load(\Yii::$app->request->post(), '');
        } else {
            $demand->load(\Yii::$app->request->get(), '');
        }
        if ($demand->validate()) {
            $model = Demand::find()->select(['title', 'content'])->where(['id' => $demand->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
        //return $this->render('about');
    }
    /**
     *
     * @return 资讯落地页
     */
    public function actionNews()
    {
        $news = new News();
        if (\Yii::$app->request->isPost) {
            $news->load(\Yii::$app->request->post(), '');
        } else {
            $news->load(\Yii::$app->request->get(), '');
        }
        if ($news->validate()) {
            $model = News::find()->select(['title', 'content', 'read_count', 'id'])->where(['id' => $news->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                $model->read_count = intval($model->read_count) + 1;
                $model->update(false);
            }
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     *
     * @return 待遇享受
     */
    public function actionWelfare()
    {
        $scenic = new Welfare();
        if (\Yii::$app->request->isPost) {
            $scenic->load(\Yii::$app->request->post(), '');
        } else {
            $scenic->load(\Yii::$app->request->get(), '');
        }
        if ($scenic->validate()) {
            $model = Scenic::find()->select(['title', 'content', 'id'])->where(['id' => $scenic->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     *
     * @return 景区落地页
     */
    public function actionScenic()
    {
        $scenic = new Scenic();
        if (\Yii::$app->request->isPost) {
            $scenic->load(\Yii::$app->request->post(), '');
        } else {
            $scenic->load(\Yii::$app->request->get(), '');
        }
        if ($scenic->validate()) {
            $model = Scenic::find()->select(['name', 'content', 'id'])->where(['id' => $scenic->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('scenic', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     * @return vip通道落地页
     */
    public function actionVipchannel()
    {
        $vipchannel = new Vipchannel();
        if (\Yii::$app->request->isPost) {
            $vipchannel->load(\Yii::$app->request->post(), '');
        } else {
            $vipchannel->load(\Yii::$app->request->get(), '');
        }
        if ($vipchannel->validate()) {
            $model = Vipchannel::find()->select(['name', 'content', 'id'])->where(['id' => $vipchannel->id, 'status' => \Yii::$app->params['talent.status']['published']])->one();
            if (!empty($model)) {
                return $this->render('scenic', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     *
     * @return 我的福利
     */
    public function actionMywelfare()
    {
        $content = array(
            '1. 一对一服务',
            '2. 无偿资助',
            '3. 税收反奖',
            '4. 创业扶持',
            '5. 住房补助',
            '6. 人才津贴',
            '7. 配偶随往',
            '8. 家属服务',
            '9. 绿色通道',
        );

        return $this->render('welfare', [
            'title' => '我的福利',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 后台管理
     */
    public function actionManage()
    {
        $content = array(
            '1. 一对一服务',
            '2. 无偿资助',
            '3. 税收反奖',
            '4. 创业扶持',
            '5. 住房补助',
            '6. 人才津贴',
            '7. 配偶随往',
            '8. 家属服务',
            '9. 绿色通道',
        );

        return $this->render('welfare', [
            'title' => '我的福利',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 人才伯乐奖
     */
    public function actionTalentbolelist()
    {
        $content = array(
        );

        return $this->render('talentbolelist', [
            'title' => '苏区人才伯乐奖',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 苏区人才伯乐奖暂行办法
     */
    public function actionBolerewardlist()
    {
        $content = array(
        );

        return $this->render('bolerewardlist', [
            'title' => '苏区人才伯乐奖',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 活跃指数
     */
    public function actionActiveindex()
    {
        $activeindex = new Activeindex();
        $content = $activeindex->getActiveindex();

        return $this->render('activeindex', [
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 注册协议
     */
    public function actionRegistrationagreement()
    {
        $content = '';

        return $this->render('register', [
            'title' => '用户注册协议',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 帮助中心
     */
    public function actionHelplist()
    {
        //$model = Help::find()->select(['title', 'url', 'id'])->orderBy("showorder ASC")->asArray()->all();
        $searchmodel = new Help();
        $dataProvider = $searchmodel->search();
        return $this->render('help', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     *
     * @return 帮助中心
     */
    public function actionHelp()
    {
        $help = new Help();
        if (\Yii::$app->request->isPost) {
            $help->load(\Yii::$app->request->post(), '');
        } else {
            $help->load(\Yii::$app->request->get(), '');
        }
        if ($help->validate()) {
            $model = Help::find()->select(['title', 'content'])->where(['id' => $help->id])->one();
            if (!empty($model)) {
                return $this->render('content', [
                    'model' => $model,
                ]);
            }
        }
    }
    /**
     *
     * @return 设置声明
     */
    public function actionSetnotice()
    {
        $content = '';

        return $this->render('setnotice', [
            'title' => '用户设置声明',
            'content' => $content,
        ]);
    }
    /**
     *
     * @return 人才伯乐奖
     */
    public function actionPay() {
        $client = new AliPayH5(\Yii::$app->params['alipay']);

        $data = [
            'title'=>"test",
            'description'=>"test 123",
            'out_trade_no' => '12345566',
            'total_amount' => 0.01
        ];
        echo $client->pay($data);
    }
}
