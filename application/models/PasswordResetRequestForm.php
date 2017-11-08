<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     *
     * @return boolean sends an email
     */
    public function sendEmail()
    {
        /** @var User $user */
        $user = User::findOne([
            'idstatus' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }

        $user->generatePasswordResetToken();
        if ($user->save()) {
            return \Yii::$app->mail->compose('passwordResetToken', ['user' => $user])
                ->setFrom(\Yii::$app->params['supportEmail'], \Yii::$app->params['supportName'])
                ->setTo($this->email)
                ->setSubject('Password reset for user ' . $user->name)
                ->send();
        }

        return false;
    }
}
 