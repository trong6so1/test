<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseUser extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%user}}';
    }
}