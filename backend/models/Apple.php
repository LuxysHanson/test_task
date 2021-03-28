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

    public function __construct($color, $config = [])
    {
        parent::__construct($config);
        $this->color = $color;
    }

    public static function tableName()
    {
        return 'apple_info';
    }

    public function eat($percent)
    {
        if ($this->status == AppleStatusEnum::STATUS_HANGING) {
            throw new Exception(Yii::t('app', "Съесть нельзя, яблоко на дереве"));
        }

        if ($this->status == AppleStatusEnum::STATUS_ROT) {
            throw new Exception(Yii::t('app', "Съесть нельзя, яблоко испорчено"));
        }

        $part = ($percent * $this->size) / 100;
        $this->size = round($this->size - $part, 2);
//        $this->save();
    }

    public function fallToGround()
    {
        $this->status = AppleStatusEnum::STATUS_FALL;
        $this->updated_at = time();
//        $this->save();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) $this->created_at = time();

        return parent::beforeSave($insert);
    }
}