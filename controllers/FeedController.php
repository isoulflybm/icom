<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Post;
use app\models\PostForm;

class FeedController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->goBack();
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionEdit()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if (
            $model->load(Yii::$app->request->post()) && $model->edit()
        ) {
            return $this->goBack();
        }

        $model->text = Post::find(Yii::$app->request->get('id'))->one()->text;
        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->delete()) {
            return $this->goBack();
        }

        $model->text = Post::find(Yii::$app->request->get('id'))->one()->text;
        return $this->render('delete', [
            'model' => $model,
        ]);
    }

    public function actionNew()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->new()) {
            return $this->goBack();
        }

        return $this->render('new', [
            'model' => $model,
        ]);
    }

    public function actionNews()
    {
        return $this->render('news');
    }

    public function actionImage()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->image()) {
            return $this->goBack();
        }
        
        return $this->render('image', [
            'model' => $model,
        ]);
    }

    public function actionImages()
    {
        return $this->render('images');
    }

    public function actionVideo()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->video()) {
            return $this->goBack();
        }
        
        return $this->render('video', [
            'model' => $model,
        ]);
    }

    public function actionVideos()
    {
        return $this->render('videos');
    }

    public function actionProduct()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PostForm();
        if ($model->load(Yii::$app->request->post()) && $model->product()) {
            return $this->goBack();
        }
        
        return $this->render('product', [
            'model' => $model,
        ]);
    }

    public function actionProducts()
    {
        return $this->render('products');
    }

}
