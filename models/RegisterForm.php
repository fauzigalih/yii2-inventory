<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model {
    public $fullName;
    public $userName;
    public $password;
    public $passwordConfirm;
    public $role;
    public $active;
    public $rememberMe = true;
    public $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['fullName', 'userName', 'password', 'passwordConfirm'], 'required'],
            ['rememberMe', 'boolean'],
            [['fullName', 'userName',], 'string', 'max' => 30],
            [['password', 'passwordConfirm'], 'string', 'max' => 255],
            ['role', 'default', 'value' => User::ROLE_USER],
            ['active', 'default', 'value' => User::STATUS_ACTIVE],
            //Validate username if exist
            ['userName', 'validateUsername'],
        ];
    }

    public function attributeLabels() {
        return [
            'userName' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function register() {
        if (!$this->validate()) {
            return null;
        } else if ($this->validate()) {
            $model = new User();
            $model->fullName = $this->fullName;
            $model->userName = $this->userName;
            $model->setPassword($this->password);
            $model->generateAuthKey();
            $model->role = $this->role;
            $model->active = $this->active;

            return $model->save();
        }
    }

    public function validateUsername($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user) {
                $this->addError($attribute,
                    'Username is exist, try another username.');
            }
        }
    }

    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->userName);
        }

        return $this->_user;
    }

}
