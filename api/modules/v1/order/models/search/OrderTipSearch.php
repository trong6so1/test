<?php

namespace api\modules\v1\order\models\search;

use common\models\OrderTip;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class OrderTipSearch extends OrderTip
{
    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrderTip::find(),
            'pagination' => [
                'pageSize' => $request['pageSize'] ?? false,
            ]
        ]);
        if (!$this->load($request, '') || !$this->validate()) {
            return $dataProvider;
        }
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'id']
        ]);
        $dataProvider->query->orderBy($sort->getOrders());
        if (!empty($request['perPage'])) {
            $dataProvider->query->limit($request['perPage']);
        }
        return $dataProvider;
    }
}