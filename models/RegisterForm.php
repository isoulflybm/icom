<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegisterForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $passwordCheck;
    public $loginMe = true;

    private $_user = false;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password and check password are required
            [['username', 'password', 'passwordCheck'], 'required'],
            [['username', 'password', 'passwordCheck'], 'trim'],
            ['username', function($attribute, $params, $validator) {
                if(
                    !preg_match('/^[^\@]+\@[^\@]+$/', $this->$attribute)
                    && !preg_match('/^\+\d{10,20}$/', $this->$attribute)
                ) {
                    $this->addError($attribute, 'Invalid email or phone number.');
                }
            }],
            [['password', 'passwordCheck'], 'string', 'min' => 8],
            // loginMe must be a boolean value
            ['loginMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Phone or email',
            'password' => 'Password',
            'passwordCheck' => 'Repeat password',
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
            $user = $this->getUser();

            if ($user || ($this->password !== $this->passwordCheck)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
            $this->_user = new User();
            $this->_user->username = $this->username;
            $this->_user->access_token = md5($this->password, false);
            $this->_user->auth_key = Yii::$app->getSecurity()->generateRandomString();
            if($this->_user->save(false) && $this->loginMe) {
                return Yii::$app->user->login($this->getUser(), 0);
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
