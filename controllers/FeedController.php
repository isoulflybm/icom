<?php

namespace app\controllers;

class FeedController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionNew()
    {
        return $this->render('new');
    }

    public function actionNews()
    {
        return $this->render('news');
    }

    public function actionImage()
    {
        return $this->render('image');
    }

    public function actionImages()
    {
        return $this->render('images');
    }

    public function actionVideo()
    {
        return $this->render('video');
    }

    public function actionVideos()
    {
        return $this->render('videos');
    }

    public function actionProduct()
    {
        return $this->render('product');
    }

    public function actionProducts()
    {
        return $this->render('products');
    }

}
