<?php

namespace common\models;

use common\models\base\BaseOrderTip;
use yii\db\ActiveQuery;

/**
 *
 * @property-read ActiveQuery $order
 */
class OrderTip extends BaseOrderTip
{
    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}