<?php

namespace app\models\queries;
use yii\db\ActiveQuery;
use creocoder\behaviors\NestedSetQuery;

class CategoryQuery extends ActiveQuery
{
    public function behaviors()
    {
        return [
            [
                'class' => NestedSetQuery::className(),
            ],
        ];
    }
}