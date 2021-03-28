<?php

namespace backend\enums;

use common\enum\Enum;
use Yii;

class AppleStatusEnum extends Enum
{

    const STATUS_HANGING = 0;
    const STATUS_FALL = 1;
    const STATUS_ROT = 2;
    const STATUS_EATEN = 3;

    public static function labels()
    {
        return [
            static::STATUS_HANGING => Yii::t('app', "Висит на дереве"),
            static::STATUS_FALL => Yii::t('app', "Упало/лежит на земле"),
            static::STATUS_ROT => Yii::t('app', "Гнилое яблоко"),
            static::STATUS_EATEN => Yii::t('app', "Съедено")
        ];
    }

    public static function colorByStatus()
    {
        return [
            static::STATUS_HANGING => "success",
            static::STATUS_FALL => "warning",
            static::STATUS_ROT => "danger"
        ];
    }
}