<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseCustomerGroup extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%customer_group}}';
    }
}