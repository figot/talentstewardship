<?php

namespace app\models;

use Yii;
use yii\base\Model;
/**
 * ValidCheck
 */
class ValidCheck extends Model
{
    public $pn;
    public $rn;
    public $id;
    public $type;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pn', 'rn', 'id', 'type'], 'trim'],
            [['pn', 'rn'], 'required'],

            [['pn', 'rn', 'id', 'type'], 'number'],
            ['rn', 'compare', 'compareValue' => 50, 'operator' => '<='],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'department' => 'department',
            'title' => 'title',
            'content' => 'content',
        ];
    }
}