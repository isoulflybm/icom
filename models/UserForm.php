<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use app\models\UsersLogos;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $username
 * @property string|null $auth_key
 * @property string|null $access_token
 *
 * @property UsersLogos[] $usersLogos
 */
class UserForm extends \yii\db\ActiveRecord
{
    public $username;
    public $password;
    public $passwordCheck;
    public $userlogo;

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
            [['username'], 'required'],
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
            // userlogo
            [['userlogo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpeg, jpg, gif'],
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
            'userlogo' => 'User Logo',
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

            if ($user && $user->id != yii::$app->user->id || ($this->password !== $this->passwordCheck)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function settings()
    {
        if ($this->validate()) {
            $this->_user = User::findOne(yii::$app->user->id);
            $this->_user->username = $this->username;
            $this->userlogo = UploadedFile::getInstance($this, 'userlogo');
            if($this->userlogo) {
                $type = $this->userlogo->type;
                if(
                    preg_match('/\.gif^|\.jpg^|\.jpeg^|\.png^/', $type)
                        && $this->userlogo->size < 65536
                ) {
                    $this->userlogo = file_get_contents($this->userlogo->tempName);
                    $userlogo = new UsersLogos();
                    $userlogo->user_id = $this->_user->id;
                    $userlogo->logo = "data:$type;base64,".base64_encode($this->userlogo);
                    $userlogo->save(false);
                }
                else {
                    $this->addError('userlogo', 'Incorrect logo. file must be smaller 64 k and mouth of gif, jpg, png type.');
                }
            }
            if($this->password) {
                $this->_user->access_token = md5($this->password, false);
            }
            $this->_user->save(false);
        }
        return false;
    }

    /**
     * Gets query for [[UsersLogos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersLogos()
    {
        return $this->hasMany(UsersLogos::class, ['user_id' => 'id']);
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
