<?php
namespace app\controllers;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\Hotel;
use app\models\Room;
use app\models\Hotelimages;
use app\models\Reservation;
use app\models\Area;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\ValidCheck;

class HotelController extends ActiveController {
    public $modelClass = 'app\models\User';
    public $user = null;
    public $userId = null;
    /**
     * @brief
     *
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'except' => ['getlist','getrooms','getareas'],
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = '';
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }
    /**
     * @brief
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->user = \yii::$app->user->identity;
        $this->userId = \Yii::$app->user->id;

        return $action;
    }
    /**
     * @brief 获取酒店列表
     */
    public function actionGetlist() {
        $arrReq = $this->getRequestParams();
        $hotel = new Hotel();
        $validator = new ValidCheck();
        $validator->load($arrReq, '');
        $hotel->load($arrReq, '');
        if ($hotel->validate() && $validator->validate()) {
//            if (empty($arrReq['latitude']) || empty($arrReq['longitude']) || empty($arrReq['sorttype'])) {
//                $model = $hotel->get($validator->rn, $validator->pn);
//            } else if ($arrReq['sorttype'] == 2){
//                $model = $hotel->getByDist($arrReq, $validator->rn, $validator->pn);
//            }
//            foreach ($model as $key => $value) {
//                $model[$key]['thumbnail'] = \Yii::$app->request->getHostInfo() . $value['thumbnail'];
//                $model[$key]['distance'] = intval($key) + 0.1;
//            }
//            $arrRes = ['list' => $model, 'total' => 3];
            if (empty($arrReq['latitude']) || empty($arrReq['longitude']) || empty($arrReq['sorttype'])) {
                $model = $hotel->get($validator->rn, $validator->pn, $arrReq);
            } else if ($arrReq['sorttype'] == 2) {
                $model = $hotel->getByDist($arrReq, $validator->rn, $validator->pn);
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取我的酒店列表
     */
    public function actionMyorderlist() {
        $arrReq = $this->getRequestParams();
        $order = new Reservation();
        $validator = new ValidCheck();
        $validator->load($arrReq, '');
        $order->load($arrReq, '');
        if ($validator->validate()) {
            $model = $order->getMyOrder($validator->rn, $validator->pn, $this->userId);
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取酒店房间列表
     */
    public function actionGetrooms() {
        $arrReq = $this->getRequestParams();
        $room = new Room();
        $hotelimages = new Hotelimages();
        $hotel = new Hotel();
        if ($room->validate() && $hotelimages->validate()) {
            $model = [];
            $roominfo = $room->get($arrReq);
            $hotelinfo = $hotel->getDetail($arrReq);
            $hotelimages = $hotelimages->get($arrReq);
            if (!empty($roominfo)) {
                $hotelinfo['imageurl'] = $hotelimages;
                $hotelinfo['room'] = $roominfo;
                $model['hotel'] = $hotelinfo;
            }
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $model);
        } else {
            return $this->_buildReturn(\Yii::$app->params['ErrCode']['PARAM_ERROR'], \Yii::$app->params['ErrMsg']['PARAM_ERROR']);
        }
    }
    /**
     * @brief 获取区域信息
     *
     */
    public function actionGetareas() {
        $areas = Area::getAreas();
        return $this->_buildReturn(\Yii::$app->params['ErrCode']['SUCCESS'], \Yii::$app->params['ErrMsg']['SUCCESS'], $areas);
    }
}