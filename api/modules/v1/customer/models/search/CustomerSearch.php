<?php

namespace api\modules\v1\customer\models\search;

use common\models\Customer;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class CustomerSearch extends Customer
{
    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find(),
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
        if (!empty($request['name'])) {
            $dataProvider->query->andFilterWhere(['or',
                ['like', 'first_name', $request['name']],
                ['like', 'last_name', $request['name']],
                ['like', 'full_name', $request['name']]]);
        }
        if (!empty($request['perPage'])) {
            $dataProvider->query->limit($request['perPage']);
        }
        return $dataProvider;
    }
}