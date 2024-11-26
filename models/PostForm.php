<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int $entity_id
 * @property string $title
 * @property string $description
 */
class PostForm extends \yii\db\ActiveRecord
{
    //public $title;
    //public $description;
    public $text;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            //[['entity_id', 'title', 'description'], 'required'],
            //[['entity_id'], 'integer'],
            //[['description'], 'string'],
            //[['title'], 'string', 'max' => 255],
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            //'entity_id' => 'Entity ID',
            //'title' => 'Title',
            //'description' => 'Description',
            'text' => 'Text',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $post = new Post();
        //$post->entity_id = 0;
        //$post->title = $this->title;
        //$post->description = $this->description;
        $post->user_id = Yii::$app->user->id;
        $post->text = $this->text;
        if($post->save(false)) {
            return true;
        }
        return false;
    }
}
