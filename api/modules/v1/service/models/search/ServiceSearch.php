<?php

namespace api\modules\v1\service\models\search;

use common\models\Service;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class ServiceSearch extends Service
{
    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Service::find(),
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
            $dataProvider->query->andFilterWhere(['LIKE', 'name', $request['name']]);
        }
        if (!empty($request['perPage'])) {
            $dataProvider->query->limit($request['perPage']);
        }
        return $dataProvider;
    }
}