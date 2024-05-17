<?php

namespace api\modules\v1\report\models\search;

use api\modules\v1\report\models\StaffIncome;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class StaffIncomeSearch extends StaffIncome
{
    public $startTime;
    public $endTime;

    public function rules(): array
    {
        return [
            [['startTime', 'endTime'], 'date', 'format' => 'php:Y-m-d'],
            ['startTime', 'default', 'value' => date('Y-m-d', strtotime('-1 month'))],
            ['endTime', 'default', 'value' => date('Y-m-d')],
        ];
    }

    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StaffIncome::report(),
            'pagination' => [
                'pageSize' => $request['perPage'] ?? 10,
            ],
            'key' => 'staff_id'
        ]);
        if (!$this->load($request, '') && !$this->validate()) {
            $dataProvider->query->andFilterWhere(['between', 'created_at',
                date('Y-m-d', strtotime('-1 month')), date('Y-m-d')]);
            return $dataProvider;
        }
        $dataProvider->query->andFilterWhere(['between', 'created_at', $this->startTime, $this->endTime]);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type']
        ]);
        $dataProvider->query->orderBy($sort->orders);
        return $dataProvider;
    }
}