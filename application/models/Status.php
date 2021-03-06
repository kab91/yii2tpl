<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "x_status".
 *
 * @property integer $id
 * @property string $name
 * @property string $owner
 * @property string $css_class
 * @property integer $sortorder
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%status}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'owner'], 'required'],
            [['owner'], 'string'],
            [['sortorder'], 'integer'],
            [['name', 'css_class'], 'string', 'max' => 50],
            [['name', 'owner'], 'unique', 'targetAttribute' => ['name', 'owner'], 'message' => 'The combination of Name and Owner has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'owner' => 'Owner',
            'css_class' => 'Css Class',
            'sortorder' => 'Sort Order',
        ];
    }

    public function getStr() {
        return '<span class="status '.$this->css_class.'">'.$this->name.'</span>';
    }

    public static function getForSelect($owner) {

        $statuses = self::find()->where(['owner'=>$owner])->orderBy('sortorder')->all();
        return ArrayHelper::map($statuses,'id','name');
    }

}
