<?php
namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use app\models\User;
use kartik\password\StrengthValidator;


/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $username; //stub for StrengthValidator

    /**
     * @var \app\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            [['password'], StrengthValidator::class, 'preset' => 'normal', 'hasUser' => false],
        ];
    }

    /**
     * Resets password.
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->password = $this->password;
        $user->removePasswordResetToken();
        return $user->save();
    }
}
 