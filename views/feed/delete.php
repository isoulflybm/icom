<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PostForm $model */
/** @var ActiveForm $form */
?>

<div class="feed-delete">
    <?php $form = ActiveForm::begin(); ?>

        <p>Подтвердите удаление</p>
        <?= $form->field($model, 'text')->textarea(
            ['style' => 'display: none', 'value' => $model->text]
        )->label() ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- feed-delete -->
