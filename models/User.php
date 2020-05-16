<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $fullName
 * @property string|null $userName
 * @property string|null $password
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property string|null $role
 * @property string|null $imageUser
 * @property int|null $active
 */
class User extends ActiveRecord implements IdentityInterface {
    public $oldPassword;
    public $newPassword;
    public $newPasswordConfirm;

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 9;

    public static $roleCategories = [
        self::ROLE_ADMIN => 'ADMIN',
        self::ROLE_USER => 'USER'
    ];
    public static $activeCategories = [
        self::STATUS_ACTIVE => "ACTIVE",
        self::STATUS_INACTIVE => "NOT ACTIVE"
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
//            [['fullName', 'userName', 'password', 'role', 'active'], 'required'],
            [['role', 'active'], 'integer'],
            [['fullName', 'userName', 'imageUser'], 'string', 'max' => 80],
            [['password', 'authKey', 'accessToken'], 'string', 'max' => 255],
            [['oldPassword', 'newPassword', 'newPasswordConfirm'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullName' => 'Full Name',
            'userName' => 'User Name',
            'password' => 'Password',
            'role' => 'Role',
            'imageUser' => 'Image User',
            'active' => 'Active',
        ];
    }
    
    public function newUser() {
        if (!$this->validate()) {
            return null;
        }
        
        $this->setPassword($this->password);
        $this->generateAuthKey();
        
        return $this->save();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['userName' => $username, /* 'active' => self::STATUS_ACTIVE */ ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                'password_reset_token' => $token,
                'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                'verification_token' => $token,
                'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password,
                $this->password);
    }
    
    public function validateStatusActive($status) {
        return ($status === self::STATUS_ACTIVE) ? true : false;
    }
    
    public function validateUsername($attribute = 'userName') {
        if (!$this->hasErrors()) {
            $user = $this->findByUsername($this->userName);
            if ($user) {
                $this->addError($attribute,
                    'Username is exist, try another username.');
                return false;
            }
        }
        return true;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }
    
    public function search()
    {
        $query = self::find()
            ->andFilterWhere(['like', 'fullName', $this->fullName])
            ->andFilterWhere(['like', 'userName', $this->userName])
            ->andFilterWhere(['=', 'role', $this->role])
            ->andFilterWhere(['=', 'active', $this->active]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8
            ]
        ]);
        
        return $dataProvider;
    }

}
