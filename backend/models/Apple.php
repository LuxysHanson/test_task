<?php

namespace backend\models;

use backend\enums\AppleStatusEnum;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Apple model
 *
 * @property integer $id
 * @property string $color
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at // дата падения
 * @property string $size
 */
class Apple extends ActiveRecord
{

    public $colors = array('black','green','white','blue','orange', 'red');

    public static function tableName()
    {
        return 'apple_info';
    }

    public function attributeLabels()
    {
        return [
            'color' => Yii::t('app', "Цвет"),
            'status' => Yii::t('app', "Статус"),
            'created_at' => Yii::t('app', "Дата появления"),
            'updated_at' => Yii::t('app', "Дата падения"),
            'size' => Yii::t('app', "Размер")
        ];
    }

}