<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "stream".
 *
 * @property int $id
 * @property int $user
 * @property string $streamname
 * @property string $streamurl
 * @property string $streamrtmp
 * @property string $poster
 * @property string $accessToken
 */
class Stream extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stream';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['streamname', 'streamurl', 'streamrtmp', 'poster', 'accessToken'], 'required'],
            [['user'], 'integer'],
            [['streamname', 'streamurl', 'streamrtmp', 'poster', 'accessToken'], 'string', 'max' => 65535],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'streamname' => 'Streamname',
            'streamurl' => 'Stream URL',
            'streamrtmp' => 'Stream RTMP',
            'poster' => 'Poster',
            'accessToken' => 'Access Token',
        ];
    }
}
