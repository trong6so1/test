<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseUserToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%user_token}}';
    }
}