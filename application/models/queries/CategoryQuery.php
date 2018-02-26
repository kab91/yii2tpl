<?php

namespace app\models\queries;
use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class CategoryQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            [
                'class' => NestedSetsQueryBehavior::class,
            ],
        ];
    }
}