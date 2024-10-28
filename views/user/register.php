<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="icom-register">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'deleted_at') ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'auth_key') ?>
        <?= $form->field($model, 'access_token') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- icom-register -->
