<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;


class UploadImg extends Model
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
    public function upload()
    {
        if ($this->validate()) {
            $md5filesign = md5(file_get_contents($this->single->tempName));
            $newName = \Yii::getAlias('@app') . '/uploads/' . $md5filesign;
            //$newName = \Yii::getAlias('@app') . '/uploads/' . $this->single->baseName . '.' . $this->single->extension;
            $this->single->saveAs($newName);
            $this->filesign = $md5filesign;
            return true;
        } else {
            return false;
        }
    }
}