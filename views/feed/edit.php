<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PostForm $model */
/** @var ActiveForm $form */
?>
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<div class="feed-edit">

    <?php $form = ActiveForm::begin(); ?>

        <!--?= $form->field($model, 'title') ? -->
        <!--?= $form->field($model, 'description')->textarea() ? -->
        <?= $form->field($model, 'text')->textarea(
            ['style' => 'display: none', 'value' => $model->text]
        )->label() ?>
        <div class="form-control" id="text"></div>
        <!-- ?= $form->field($model, 'text')->widget(\bizley\quill\Quill\bizley\quill\Quill::className(), []) ? -->
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- feed-edit -->
<script>
    var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
        ['blockquote', 'code-block'],

        [{ 'header': 1 }, { 'header': 2 }],               // custom button values
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
        [{ 'direction': 'rtl' }],                         // text direction

        [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        [ 'link', 'image', 'video', 'formula' ],          // add's image support
        [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
        [{ 'font': [] }],
        [{ 'align': [] }],

        ['clean']                                         // remove formatting button
    ];
    const editor = new Quill('#text', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
    });
    editor.on('text-change', (delta, oldDelta, source) => {
        if (source == 'api') {
            //console.log('An API call triggered this change.');
        } else if (source == 'user') {
            //console.log('A user action triggered this change.');
            $('#postform-text').val(editor.getSemanticHTML());
        }
    });
    setTimeout(() => {
        $('#text').css('height', window.innerHeight + 'px');
        editor.root.innerHTML = '<?= $model->text ?>';
    }, 1000);
</script>
