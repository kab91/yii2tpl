<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
	public $email;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
            ['email', 'required'],
            ['email', 'filter', 'filter' => 'trim'],
			['email', 'email'],
			['email', 'unique', 'targetClass' => '\app\models\User',
                'message' =>  'Email already in use by another user.'],
		];
	}

	/**
	 * Signs user up.
	 * @return User saved model
	 */
	public function signup()
	{
		if ($this->validate()) {
			return User::create($this->attributes);
		}
		return null;
	}
}
 