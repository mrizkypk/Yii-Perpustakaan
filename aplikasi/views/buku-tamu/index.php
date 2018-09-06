<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuTamuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buku Tamu';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation" class="active"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>     
    </ul>
</div>

<div class="col-md-10 content">
    <div class="buku-tamu-index">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'santri',
                    'value' => 'santri.nama'
                ],
                [
                    'label' => 'Tanggal',
                    'attribute' => 'tanggal',
                    'value' => function ($model) {
                        return $model->getTanggal();
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<center>{delete}</center>'
                ]
            ],
        ]); ?>
    </div>
</div>

<script type="text/javascript">

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function playSound() {
    var audio = new Audio('<?php echo Url::home(true); ?>beep.mp3');
    audio.play();
}

function playSoundError() {
    var audio = new Audio('<?php echo Url::home(true); ?>error.mp3');
    audio.play();
}

$(function() {
        var notifikasi = getParameterByName('notifikasi');
        if (notifikasi == 'ya') {
            playSound();
        }
        if (notifikasi == 'gagal') {
            playSoundError();
        }
        var pressed = false; 
        var chars = []; 
        $(window).keypress(function(e) {
            if (e.which >= 48 && e.which <= 57) {
                chars.push(String.fromCharCode(e.which));
            }
            if (pressed == false) {
                setTimeout(function(){
                    if (chars.length >= 1) {
                        var barcode = chars.join("");
                        window.location = "<?php echo Url::to(['buku-tamu/create']); ?>?nis=" + barcode;
                    }
                    chars = [];
                    pressed = false;
                },500);
            }
            pressed = true;
        });
});
</script>