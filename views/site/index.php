<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'i.com';
?>

<p class="video" style="display: none">
    <video id="video-player" class="video-js vjs-default-skin" autoplay controls
        data-setup='{"fluid": true}' preload="auto" crossorigin="true"
        width="640" height="288" poster="/news/icom/img/live.png">
    </video>
</p>
<script>
    function streamplay(id, streamurl) {
        play = videojs("video-player");
        $('#video-player').css('width',
            ($(window).width() - $('#video-player')[0].getBoundingClientRect().width) * 0.9
        );
        $('#video-player').css('height',
            ($(window).height() - $('#video-player')[0].getBoundingClientRect().height) * 0.9
        );
        play.ready(() => {
            if ($('#stream-' + id).prop('class') == 'stream') {
                play.src({
                    src: streamurl,
                    type: 'application/x-mpegURL',
                    poster: 'img/live.png',
                });
                play.play();
            }
            else {
                alert('Stream is not going. Please, try later or select another stream.');
            }
        });
        play.on('play', (e) => {
            $('.video').css('display', 'block');
            // $('#video-player').css('width', play.width);
            // $('#video-player').css('height', (play.width / $('#video-player').css('width') * play.height) * 0.9);
        });
        play.on('error', (e) => {
            console.log(e);
            alert('Stream is not going. Please, try later or select another stream.');
        });
        play.on('pause', (e) => {
            $('.video').css('display', 'none');
        });
    }
</script>
<div class="site-index">

<?php
    foreach($streams as $stream) {
        $class = '';
        if (@file_get_contents($stream->streamurl)) {
            $class = ' class="streaming"';
        }
        else {
            $class = ' class="nostream"';
        }
?>
        <table class="stream" id="stream-<?= $stream->id ?>"
            data-id="<?= $stream->id ?>" data-streamurl="<?= $stream->streamurl ?>"
        >
            <tr><th><a href="javascript:streamplay('<?= $stream->id ?>', '<?= $stream->streamurl ?>')"<?= $class ?>>
                <?= $stream->streamname ?>
            </a></th></tr>
            <tr><td><a href="javascript:streamplay('<?= $stream->id ?>', '<?= $stream->streamurl ?>')"<?= $class ?>>
                <img src="<?= Url::Base() . '/' . $stream->poster ?>">
            </a></td></tr>
        </table>
<?php
    }
?>
    <script>
        window.onload = () => {
            setInterval(() => {
                streams = $('.stream');
                streams.each((i) => {
                    $.get($(streams[i]).data('streamurl'), (data) => {
                    }).done((data) => {
                        $(streams[i]).find('a').prop('title', 'streaming');
                        $(streams[i]).find('a').first().prop('class', 'streaming');
                    }).fail((error) => {
                        $(streams[i]).find('a').prop('title', 'no stream yet');
                        $(streams[i]).find('a').first().prop('class', 'nostream');
                    }).always((data) => {});
                });
            }, 30000);
            /*setTimeout(() => {
                ws = new WebSocket('wss://192.168.0.164:8080/');
                ws.onerror = (e) => {
                    console.log(e);
                };
                ws.onopen = () => {
                    console.log('Open');
                    ws.send('Hello!');
                };
                ws.onmessage = (e) => {
                    console.log(e);
                };
                ws.onclose = () => {
                    console.log('Close');
                }
            }, 300);*/
        }
    </script>
</div>

