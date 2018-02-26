<?php
namespace app\models;

use Yii;
use yii\base\Model;
use kartik\password\StrengthValidator;

/**
 * Login form
 */
class PasswordForm extends Model
{
    public $password;
    public $newpassword;
    public $username; //stub for StrengthValidator

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['password', 'newpassword'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            [['newpassword'], StrengthValidator::class, 'preset' => 'normal', 'hasUser' => false],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Current password',
            'newpassword' => 'New password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        $user = Yii::$app->user->getIdentity();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Wrong current password');
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->getIdentity();
            $user->changePassword($this->newpassword);
            return true;
        } else {
            return false;
        }
    }
}
