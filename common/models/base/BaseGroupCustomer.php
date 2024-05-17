<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseGroupCustomer extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%group_customer}}';
    }
}