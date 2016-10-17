<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "x_user".
 *
 * @property integer $id
 * @property integer $idstatus
 * @property integer $idavatar
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $identity
 * @property string $site
 *
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
            'idstatus' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'email' => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idstatus', 'idavatar',], 'integer'],
            [['name', 'auth_key', 'password_hash'], 'required'],
            [['name', 'email', 'identity', 'site'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 100],
            [['password_reset_token'], 'string', 'max' => 50],
            ['avatar', 'safe'],
        ];
    }

    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'idstatus']);
    }

    public function getRoles()
    {
        return $this->hasMany(AuthItem::className(), ['name' => 'item_name'])->viaTable('x_auth_assignment',
            ['user_id' => 'id']);
    }

    public function getRolesStr()
    {
        return implode(ArrayHelper::map($this->roles, 'name', 'name'), ',');
    }

    public static function create($attributes)
    {
        $password = Yii::$app->getSecurity()->generateRandomString(10);
        $email = $attributes['email'];
        list($name,) = explode('@', $email);

        /** @var User $user */
        $user = new static();
        $user->name = $name;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        if ($user->save()) {
            Yii::$app->mail->compose('signup', ['user' => $user, 'password' => $password])
                ->setTo($email)
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['supportName']])
                ->setSubject(Yii::t('app', 'Registration on {appname}', ['appname' => Yii::$app->name]))
                ->send();

            return $user;
        } else {
            return null;
        }
    }

    public function changePassword($newpassword)
    {
        $this->setPassword($newpassword);
        $this->generateAuthKey();
        $this->save(false);
    }

    static public function getRedirectUrl()
    {
        $url = Yii::$app->user->getReturnUrl();
        return $url;
    }

    public function getUrl()
    {
        return Yii::$app->request->baseUrl . '/user/' . $this->id;
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
    public static function findIdentityByAccessToken($token, $type = null)
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
    public static function findByPasswordResetToken($token, $type = null)
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

    public static function getRolesList()
    {
        return ArrayHelper::map(AuthItem::find()->where('type = 2')->all(), 'name', 'name');
    }
}