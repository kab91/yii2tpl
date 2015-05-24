<?php

namespace app\models;
use yii\db\ActiveRecord;
use creocoder\behaviors\NestedSet;
use app\models\queries\CategoryQuery;

/**
 * This is the model class for table "x_category".
 *
 * @property integer $id
 * @property string $name
 */
class Category extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%category}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string', 'max' => 50]
		];
	}

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => NestedSet::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
		];
	}

    public static function getForSelect($with_root = false)
    {
        $res = array();
        $rawtree = static::find()->addOrderBy('lft')->all();
        if (!$with_root) array_shift($rawtree);

        foreach ($rawtree as $curr) {
            $res[$curr->id] = str_repeat(' . ', ($curr->level - 1 - ($with_root?0:1))) . $curr->name;
        }

        return $res;
    }

    public function getFullName() {
        $res=[];
        $ancestors=$this->ancestors()->all();
        array_shift($ancestors); //remove root

        foreach($ancestors as $curr) {
            $res[]=$curr->name;
        }
        $res[]=$this->name;
        return implode(' / ', $res);
    }
}
