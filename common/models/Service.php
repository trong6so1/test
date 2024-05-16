<?php

namespace common\models;

use common\models\base\BaseService;
use yii\db\ActiveQuery;

class Service extends BaseService
{
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}