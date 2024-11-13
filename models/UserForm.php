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
                if(preg_match('/image\/\w+/', $type)) {
                    if($this->userlogo->size >= 65536) {
                        if(preg_match('/gif$/', $type)) {
                            $this->userlogo = imagecreatefromgif($this->userlogo->tempName);
                        }
                        elseif(preg_match('/jpe?g$/', $type)) {
                            $this->userlogo = imagecreatefromjpeg($this->userlogo->tempName);
                        }
                        elseif(preg_match('/png$/', $type)) {
                            $this->userlogo = imagecreatefrompng($this->userlogo->tempName);
                        }
                        else {
                            $this->addError('userlogo', 'Incorrect logo. file must be smaller 64 k and mouth of gif, jpg, png type.');
                        }
                        $w = 160; $h = 120;
                        $width = imagesx($this->userlogo);
                        $height = imagesy($this->userlogo);
                        if($width > $height) {
                            $h = ($height / $width) * 120;
                        }
                        else {
                            $w = ($width / $height) * 160;
                        }
                        $userlogo = imagecreate($w, $h);
                        imagecopyresized($userlogo, $this->userlogo, 0, 0, 0, 0, $w, $h, $width, $height);
                        ob_start();
                        if(preg_match('/gif$/', $type)) {
                            imagegif($userlogo);
                            $this->userlogo = ob_get_contents();
                        }
                        elseif(preg_match('/jpe?g$/', $type)) {
                            imagejpeg($userlogo);
                            $this->userlogo = ob_get_contents();
                        }
                        elseif(preg_match('/png$/', $type)) {
                            imagepng($userlogo);
                            $this->userlogo = ob_get_contents();
                        }
                        else {
                            $this->addError('userlogo', 'Incorrect logo. file must be smaller 64 k and mouth of gif, jpg, png type.');
                        }
                        imagedestroy($userlogo);
                        ob_end_clean();
                    }
                    else {
                        $this->userlogo = file_get_contents($this->userlogo->tempName);
                    }
                    $userlogo = new UsersLogos();
                    $userlogo->user_id = $this->_user->id;
                    $userlogo->logo = "data:$type;base64,".base64_encode($this->userlogo);
                    $userlogo->save(false);
                }
                else {
                    $this->addError('userlogo', 'Incorrect logo. file must be smaller 64 k and mouth of gif, jpg, png type.');
                }
                /*if(preg_match('/image\/\w+/', $type) && $this->userlogo->size < 65536
                ) {
                    $this->userlogo = file_get_contents($this->userlogo->tempName);
                    $userlogo = new UsersLogos();
                    $userlogo->user_id = $this->_user->id;
                    $userlogo->logo = "data:$type;base64,".base64_encode($this->userlogo);
                    $userlogo->save(false);
                }
                else {
                    $this->addError('userlogo', 'Incorrect logo. file must be smaller 64 k and mouth of gif, jpg, png type.');
                }*/
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
