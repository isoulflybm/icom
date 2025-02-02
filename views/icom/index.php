<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
//$this->title = 'ICom';
//$this->params['breadcrumbs'][] = $this->title;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/1.1.0/timeago.min.js"></script>
<div class="site-index">
<?php foreach($model as $post): ?>
<p>
    <b><?= $post->created_at ?></b>
    <?= $post->text ?>
</p>
    <?php if($post->user_id == Yii::$app->user->id): ?>
        <div>
            <a href="<?= Url::to(['feed/edit', 'id' => $post->id]) ?>">edit</a>
            <a href="<?= Url::to(['feed/delete', 'id' => $post->id]) ?>">delete</a>
        </div>
    <?php endif ?>
<?php endforeach ?>
</div>
<script>
</script>
