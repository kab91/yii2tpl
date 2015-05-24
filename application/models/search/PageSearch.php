<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Page;

/**
 * PageSearch represents the model behind the search form about Page.
 */
class PageSearch extends Model
{
	public $id;
	public $slug;
	public $title;
	public $content;

	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['slug', 'title', 'content'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'slug' => 'Slug',
			'title' => 'Title',
			'content' => 'Content',
		];
	}

	public function search($params)
	{
		$query = Page::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'slug', true);
		$this->addCondition($query, 'title', true);
		$this->addCondition($query, 'content', true);
		return $dataProvider;
	}

	protected function addCondition($query, $attribute, $partialMatch = false)
	{
		$value = $this->$attribute;
		if (trim($value) === '') {
			return;
		}
		if ($partialMatch) {
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
