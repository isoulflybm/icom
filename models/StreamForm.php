<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

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
class StreamForm extends Model
{
    public $id;
    public $user;
    public $streamname;
    public $streamurl;
    public $streamrtmp;
    public $poster;
    public $accessToken;
    public $remove;
    public $edit_id;
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
            [['user', 'remove', 'edit_id'], 'integer'],
            [['streamname', 'streamurl', 'streamrtmp', 'accessToken'], 'string', 'max' => 65535],
            [['poster'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
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

    /**
     * Add a stream using the provided accessToken.
     * @return bool whether the stream is added in successfully
     */
    public function stream()
    {
        $this->poster = UploadedFile::getInstance($this, 'poster');
        
        if ($this->poster && $this->validate()) {
            if ($this->getStream()) {
                if (!$this->hasErrors()) {
                    $this->addError('streamname', 'Incorrect stream name.');
                }
                return false;
            }
            $this->poster->saveAs(Yii::$app->basePath . '/web/img/' . $this->accessToken);
            $stream = new Stream();
            $stream->user = Yii::$app->user->id;
            $stream->streamname = $this->streamname;
            $stream->streamurl = $this->streamurl;
            $stream->streamrtmp = $this->streamrtmp;
            $stream->poster = 'img/' . $this->accessToken;
            $stream->accessToken = md5($this->accessToken);
            if ($stream->save(false)) {
                return true;
            }
        }
        elseif ($this->remove) {
            $stream = Stream::findOne($this->remove);
            if ($stream->delete(false)) {
                return true;
            }
        }
        elseif ($this->edit_id) {
            if ($this->streamname) {
                $stream = Stream::findOne($this->edit_id);
                $stream->streamname = $this->streamname;
                if ($stream->save(false)) {
                    return true;
                }
            }
            else {
                $this->poster = UploadedFile::getInstance($this, 'poster');

                if ($this->poster) {
                    $stream = Stream::findOne($this->edit_id);
                    @unlink(Yii::$app->basePath . '/web/' . $stream->poster);
                    $this->poster->saveAs(Yii::$app->basePath . '/web/img/' . $this->accessToken);
                    $stream->poster = 'img/' . $this->accessToken;
                    if ($stream->save(false)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getStream()
    {
        return Stream::findOne($this->id);
    }
}
