<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;


class Upload extends Model
{
    /**
     * @brief 单个文件上传对应的属性
     */
    public $single;
    public $filesign=null;

    /**
     * @brief
     */
    public function rules()
    {
        return [
            [['single'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    /**
     * @brief  单个文件上传对应方法
     */
    public function upload($uid)
    {
        if ($this->validate()) {
            $md5filesign = md5(file_get_contents($this->single->tempName));
            $newName = \Yii::getAlias('@image') . "/app/" . $md5filesign;
            $this->single->saveAs($newName);
            $this->filesign = \Yii::$app->request->getHostInfo() . "/image/app/" . $md5filesign;
            $talentinfo = Talentinfo::findIdentity($uid);
            if ($talentinfo !== null) {
                $talentinfo->portrait = $md5filesign;
                if (!$talentinfo->save(false)) {
                    throw new \Exception();
                }
            } else {
                $talent = new Talentinfo();
                $talent->user_id = $uid;
                $talent->portrait = $md5filesign;
                if (!$talent->save(false)) {
                    throw new \Exception();
                }
            }
            return ['url' => $this->filesign, 'sign' => $md5filesign];
        } else {
            return false;
        }
    }
}