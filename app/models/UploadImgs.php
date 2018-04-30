<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * @brief  多个文件上传
 */
class UploadImgs extends Model
{
    /**
     * @brief  多个文件上传对应的属性
     */
    public $multiple;
    public $filesignlist;

    /**
     * @brief
     */
    public function rules()
    {
        return [
            [['multiple'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg','maxFiles' => 4],
        ];
    }
    /**
     * @brief  多个文件上传对应方法
     */
    public function uploadMultiple()
    {
        if ($this->validate()) {
            foreach ($this->multiple as $file) {
                $md5filesign = md5(file_get_contents($file->tempName));
                //$newName = \Yii::getAlias('@app') . '/uploads/' . $file->baseName . '.' . $file->extension;
                $newName = \Yii::getAlias('@app') . '/uploads/' . $md5filesign;
                $file->saveAs($newName);
                $this->filesignlist[] = $md5filesign;
            }
            return true;
        } else {
            return false;
        }
    }
}