<?php

namespace api\modules\v1\customer\models;

use yii\behaviors\TimestampBehavior;

/**
 * @property mixed|null $id
 */
class Customer extends \common\models\Customer
{
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'update_at',
            ]
        ];
    }
}