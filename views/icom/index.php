<?php

/** @var yii\web\View $this */
//$this->title = 'ICom';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">
<?php foreach($model as $post): ?>
<p>
    <b><?= $post->created_at ?></b>
    <?= $post->text ?>
</p>
<?php endforeach ?>
</div>
