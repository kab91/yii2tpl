<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use app\models\Status;

/**
 * User model
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 *
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 *
 * @property integer $idavatar
 * @property integer $idstatus
 *
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Status $status 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    public $avatar;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
     
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idstatus' => Yii::t('app','Статус'),
            'name' => Yii::t('app','Имя'),
            'created_at' => Yii::t('app','Создан'),
            'updated_at' => Yii::t('app','Обновлен'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],

            ['site', 'url'],

            ['avatar', 'safe'],
        ];
    }

    public function getStatus() {
        return $this->hasOne(Status::className(), ['id' => 'idstatus']);
    }

    public static function create($attributes)
    {
        $password = Yii::$app->getSecurity()->generateRandomString(10);
        $email = $attributes['email'];
        list($name, ) = explode('@',$email);

        /** @var User $user */
        $user = new static();
        $user->name = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            Yii::$app->mail->compose('signup', ['user' => $user, 'password'=>$password])
                ->setTo($email)
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['supportName']])
                ->setSubject('Регистрация на '.Yii::$app->name)
                ->send();

            return $user;
        } else {
            return null;
        }
    }

    public function changePassword($newpassword) {
        $this->setPassword($newpassword);
        $this->generateAuthKey();
        $this->save(false);
    }

    static public function getRedirectUrl()
    {
        $url = Yii::$app->user->getReturnUrl();
        return $url;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return self
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'idstatus' => static::STATUS_ACTIVE]);
    }

    /**
     * Finds user by identity
     *
     * @param string $identity
     * @return self
     */
    public static function findByIdentity($identity)
    {
        return static::findOne(['identity' => $identity, 'idstatus' => static::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type=null)
    {
        throw new BadRequestHttpException('not implemented yet');
    }


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @param $type
     * @return self
     */
    public static function findByPasswordResetToken($token, $type=null)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return User::findOne(
            [
                'password_reset_token' => $token,
                'idstatus' => User::STATUS_ACTIVE,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->getSecurity()->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function fromSocial()
    {
        return !empty($this->identity);
    }
}
