<?php

namespace backend\enums;

use common\enum\Enum;
use Yii;

class AppleStatusEnum extends Enum
{

    const STATUS_HANGING = 0;
    const STATUS_FALL = 1;
    const STATUS_ROT = 2;

    public static function labels()
    {
        return [
            static::STATUS_HANGING => Yii::t('app', "Висит на дереве"),
            static::STATUS_FALL => Yii::t('app', "Упало/лежит на земле"),
            static::STATUS_ROT => Yii::t('app', "Гнилое яблоко")
        ];
    }
}