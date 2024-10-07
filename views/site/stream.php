<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Streaming';
$this->params['breadcrumbs'][] = $this->title;

/** @var yii\web\View $this */
/** @var app\models\StreamForm $model */
/** @var ActiveForm $form */
?>

<style>
    #streaming {
        display: none;
    }
    #new_stream {
        position: fixed;
        right: 16px;
        width: 32px;
        height: 32px;
        border: 1px solid #ccf;
        background: #99f;
        color: #eff;
        border-radius: 50%;
    }
</style>
<script>
    function aCopyUrl(event, id) {
        navigator.clipboard.writeText(event).then(() => {
            //document.getElementsByClassName('field-stream' + '-' + id)[0].getElementsByClassName('help-block')[0].innerHTML = 'URL copied succeful done';
            //document.getElementsByClassName('field-stream' + '-' + id)[0].getElementsByClassName('help-block')[0].classList.add('copied');
            document.getElementById('stream' + '-' + id).getElementsByClassName('help-block')[0].innerHTML = 'URL copied succeful done';
            document.getElementById('stream' + '-' + id).getElementsByClassName('help-block')[0].classList.add('copied');
            setTimeout(() => {
                //document.getElementsByClassName('field-stream' + '-' + id)[0].getElementsByClassName('help-block')[0].innerHTML = '';
                //document.getElementsByClassName('field-stream' + '-' + id)[0].getElementsByClassName('help-block')[0].classList.remove('copied');
                document.getElementById('stream' + '-' + id).getElementsByClassName('help-block')[0].innerHTML = '';
                document.getElementById('stream' + '-' + id).getElementsByClassName('help-block')[0].classList.remove('copied');
            }, 3333);
        });
        return false;
    }
    function copyUrl(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        navigator.clipboard.writeText('<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>').then(() => {
            document.getElementsByClassName('field-streamform-stream' + col)[0].getElementsByClassName('help-block')[0].innerHTML = 'URL copied succeful done';
            document.getElementsByClassName('field-streamform-stream' + col)[0].getElementsByClassName('help-block')[0].classList.add('copied');
            setTimeout(() => {
                document.getElementsByClassName('field-streamform-stream' + col)[0].getElementsByClassName('help-block')[0].innerHTML = '';
                document.getElementsByClassName('field-streamform-stream' + col)[0].getElementsByClassName('help-block')[0].classList.remove('copied');
            }, 3333);
        });
        return false;
    }
    function keyDown(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function keyUp(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function keyPress(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function copy(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function focus(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function blur(event, col) {
        document.getElementById('streamform-stream' + col).value = '<?= Yii::$app->params["hlsServer"] . "/" . $accessToken ?>';
        event.stopPropagation();
        return false;
    }
    function remove(event, id) {
        if (confirm('Remove this?')) {
            form = $('<form>');
            csrf = $('<input>');
            del = $('<input>');
            form.id = 'w1';
            form.prop('action', '<?= Url::current() ?>');
            form.prop('method', 'post');
            csrf.name = '<?= Yii::$app->request->getCsrfParam() ?>';
            csrf.value = '<?= Yii::$app->request->getCsrfToken() ?>';
            csrf.type = 'hidden';
            form.append(csrf);
            del.name = 'StreamForm[remove]';
            del.value = id;
            del.type = 'hidden';
            form.append(del);
            //form.append($('<input type="submit">'));
            $('body').append(form);
            form.submit();
        }
        //event.stopPropagation();
        return false;
    }
    function editname(event, id) {
        if (
            /*name = prompt('Enter new name', $('#streamname-' + id).html())*/
            name = prompt('Enter new name', $('#streamname-' + id).data('streamname'))
        ) {
            if (name.length) {
                form = $('<form style="display: none">');
                csrf = $('<input>');
                edit_id = $('<input>');
                edit = $('<input>');
                form.id = 'w1';
                form.prop('action', '<?= Url::current() ?>');
                form.prop('method', 'post');
                csrf.name = '<?= Yii::$app->request->csrfParam ?>';
                csrf.value = '<?= Yii::$app->request->csrfToken ?>';
                csrf.type = 'hidden';
                form.append(csrf);
                edit_id.name = 'StreamForm[edit_id]';
                edit_id.value = id;
                edit_id.type = 'hidden';
                form.append(edit_id);
                streamname.name = 'StreamForm[streamname]';
                streamname.prop('value', name);
                streamname.type = 'text';
                form.append(streamname);
                //form.append($('<input type="submit">'));
                $('body').append(form);
                form.submit();
            }
        }
        //event.stopPropagation();
        return false;
    }
    function editposter(event, id) {
        poster = $('<input type="file" style="display:none" name="StreamForm[poster]" accept="image/*">');
        $('body').append(poster);
        poster.change(() => {
            if (poster[0].files) {
                form = $('<form style="display: none">');
                csrf = $('<input>');
                edit_id = $('<input>');
                access_token = $('<input>');
                form.id = 'w1';
                form.prop('action', '<?= Url::current() ?>');
                form.prop('enctype', 'multipart/form-data');
                form.prop('method', 'post');
                csrf.name = '<?= Yii::$app->request->csrfParam ?>';
                csrf.value = '<?= Yii::$app->request->csrfToken ?>';
                csrf.type = 'hidden';
                form.append(csrf);
                edit_id.name = 'StreamForm[edit_id]';
                edit_id.value = id;
                edit_id.type ='hidden';
                form.append(edit_id);
                access_token.name = 'StreamForm[accessToken]';
                access_token.value = '<?= $accessToken ?>';
                access_token.type ='hidden';
                form.append(access_token);
                form.append(poster);
                //form.append($('<input type="submit">'));
                $('body').append(form);
                form.submit();
                //event.stopPropagation();
                return true;
            }
        });
        poster.trigger('click');
    }
    function new_stream() {
        $('#list').css('display', 'none');
        $('#streaming').css('display', 'block');
    }
    function roll_back() {
        $('#list').css('display', 'block');
        $('#streaming').css('display', 'none');
    }
</script>

<div class="site-stream">

    <button onclick="new_stream()" id="new_stream">+</button>
    <article id="list">
        <h1>Your streams list</h1>

<?php
        foreach($streams as $stream) {
?>
            <table class="stream" id="stream-<?= $stream->id ?>"
                data-id="<?= $stream->id ?>" data-streamurl="<?= $stream->streamurl ?>"
            >
                <tr><th id="streamname-<?= $stream->id ?>"
                    data-id="<?= $stream->id ?>" data-streamname="<?= $stream->streamname ?>">
                    <a href="javascript:editname(event, '<?= $stream->id ?>')">
                        <?= $stream->streamname ?>
                    </a>
                </th>
                <td class="remove">
                    <a id="remove-< ?= $stream->id ? >"
                        href="javascript:remove(event, '<?= $stream->id ?>')"
                    >Remove</a>
                </th></tr>
                <tr><td colspan="2">
                    <a href="javascript:editposter(event, '<?= $stream->id ?>')">
                        <img src="<?= Url::Base() . '/' . $stream->poster ?>">
                    </a>
                </td></tr>
                <tr><td>
                    <a id="streamrtmp-<?= $stream->id ?>"
                        href="javascript:aCopyUrl('<?= $stream->streamrtmp ?>', '<?= $stream->id ?>')"
                        title="<?= $stream->streamrtmp ?>"
                    >Copy link</a>
                </td></tr>
                <tr><td colspan="2" class="help-block"></td></tr>
            </table>
<?php
        }
?>
    </article>
    
    <article id="streaming">
        <h2><?= Html::encode($this->title) ?></h2>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <!--?= $form->field($model, 'user') ?-->
        <?= $form->field($model, 'accessToken')->hiddenInput([
                'value' => $accessToken
        ])->label(false) ?>
        <?= $form->field($model, 'streamname')->textInput() ?>
        <?= $form->field($model, 'streamurl')->textInput([
                'value' => Yii::$app->params['hlsServer'] . '/' . $accessToken . '.m3u8',
                'onclick' => 'copyUrl(event, "url")', 'oncopy' => 'copy(event, "url")',
                'onfocus' => 'focus(event, "url")', 'onblur' => 'blur(event, "url")',
                'onkeydown' => 'keyDown(event, "url")', 'onkeyup' => 'keyUp(event, "url")',
                'onkeypress' => 'keyPress(event, "url")',
        ]) ?>
        <?= $form->field($model, 'streamrtmp')->textInput([
                'value' => Yii::$app->params['rtmpServer'] . '/' . $accessToken,
                'onclick' => 'copyUrl(event, "rtmp")', 'oncopy' => 'copy(event, "rtmp")',
                'onfocus' => 'focus(event, "rtmp")', 'onblur' => 'blur(event, "rtmp")',
                'onkeydown' => 'keyDown(event, "rtmp")', 'onkeyup' => 'keyUp(event, "rtmp")',
                'onkeypress' => 'keyPress(event, "rtmp")',
        ]) ?>
        <?= $form->field($model, 'poster')->fileInput(['accept' => 'image/*']) ?>
        
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            <?= Html::button('Rollback', ['class' => 'btn btn-primary', 'onclick' => 'roll_back()']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </article>

</div><!-- site-stream -->
