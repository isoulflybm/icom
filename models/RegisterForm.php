<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property string $accessToken
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $confirm_password;
    public $authKey;
    public $accessToken;

    private $_user = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirm_password'], 'required'],
            [['username', 'password', 'confirm_password'], 'string', 'max' => 65535],
            //[['password', 'confirm_password'], 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->confirm_password)
            {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Sign up a user using the provided username and password.
     * @return bool whether the user is signed in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            if ($this->getUser()) {
                if (!$this->hasErrors()) {
                    $this->addError('password', 'Incorrect username or password.');
                    $this->addError('confirm_password', 'Incorrect username or password.');
                }
                return false;
            }
            $user = new User();
            $user->username = $this->username;
            $user->password = Yii::$app->security->generatePasswordHash($this->password);
            $user->authKey = Yii::$app->security->generateRandomString();
            $user->accessToken = md5($user->authKey);
            if ($user->save(false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
