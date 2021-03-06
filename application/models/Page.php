<?php

namespace app\models;

use yii\helpers\HtmlPurifier;
use Yii;

/**
 * This is the model class for table "x_page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $content
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'content'], 'required'],
            [['content'], 'string'],
            [['content'], 'filter', 'filter' => [new HtmlPurifier(), 'process']],
            [['slug', 'title', 'seo_keywords', 'seo_description'], 'string', 'max' => 255],
            [['slug'], 'unique']
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
            'seo_keywords' => 'SEO keywords',
            'seo_description' => 'SEO description',
        ];
    }

    public function getUrl()
    {
        return Yii::$app->request->baseUrl . '/page/' . $this->slug;
    }
}
