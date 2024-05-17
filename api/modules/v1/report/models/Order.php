<?php

namespace api\modules\v1\report\models;

use common\models\Order as OrderAlias;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 *
 * @property-read void $status
 * @property mixed|null $order_status
 */
class Order extends OrderAlias
{
    public $quantity;
    public $order_status_title;

    public function fields(): array
    {
        return [
            'order_status',
            'order_status_title',
            'quantity',
            'tip',
            'tax',
            'total_before_discount',
            'total_after_discount',
            'total_cash_discount',
            'total_change'
        ];
    }

    public static function report(): ActiveQuery
    {
        $queryOrderStatusTitle = 'CASE ';
        foreach (parent::getOrderStatusTitles() as $status => $title) {
            $queryOrderStatusTitle .= ' When order_status = "' . $status . '" THEN "' . $title . '"';
        }
        $queryOrderStatusTitle .= ' END';
        return parent::find()
            ->select([
                'order_status',
                'order_status_title' => new Expression($queryOrderStatusTitle),
                'COUNT(*) AS quantity',
                'SUM(total_after_discount) AS total_after_discount',
                'SUM(total_before_discount) AS total_before_discount',
                'SUM(total_cash_discount) AS total_cash_discount',
                'SUM(total_change) AS total_change',
                'SUM(tip) AS tip',
                'SUM(tax) AS tax',
                'SUM(service_fee) AS service_fee',
            ])
            ->andWhere(['customer_id' => null])
            ->andWhere(['IN', 'order_status', parent::getOrderStatuses()])
            ->groupBy(['order_status']);
    }
}