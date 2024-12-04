<?php

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
<?php endforeach ?>
</div>
<script>
</script>
