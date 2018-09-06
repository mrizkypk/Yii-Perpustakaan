<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SantriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Santri';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation" class="active"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
    </ul>
</div>

<div class="col-md-10 content">
    <div class="santri-index">
        <?php if (isset($_GET['csv'])): ?>
            <div class="alert alert-success" role="alert">
                <h4><b>Semua data santri dari berkas csv berhasil dibuat!</b></h4>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['kartu'])): ?>
            <div class="alert alert-success" role="alert">
                <h4><b>Semua kartu perpustakaan santri berhasil dibuat!</b></h4>
                <br>
                Silahkan buka <b>Windows Explorer</b> ke alamat ini:
                <br><br>
                <b><i><?php echo dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR; ?>kartu</i></b>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['riwayat'])): ?>
            <div class="alert alert-success" role="alert">
                <h4><b>Semua kartu riwayat perpustakaan kosong santri berhasil dibuat!</b></h4>
                <br>
                Silahkan buka <b>Windows Explorer</b> ke alamat ini:
                <br><br>
                <b><i><?php echo dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR; ?>riwayat</i></b>
            </div>
        <?php endif; ?>
        <p>
            <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            <button class="tambah-santri-csv btn btn-warning">Tambah Dari Berkas.CSV</button>
            <?= Html::a('Buat Semua Kartu Perpustakaan', ['semua-kartu'], ['class' => 'btn btn-blue']) ?>
            <?= Html::a('Buat Semua Kartu Riwayat Perpustakaan Kosong', ['semua-riwayat'], ['class' => 'btn btn-info']) ?>
        </p>
        <?php Pjax::begin(['id' => 'santri']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'label' => 'NIS',
                    'attribute' => 'nis',
                    'format' => 'text'
                ],
                'nama',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<center>{kartu} {riwayat} {update} {delete}</center>',
                    'buttons' => [
                        'kartu' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-credit-card"></span>', $url, ['title' => 'Buat Kartu Perpustakaan', 'data-confirm' => 'Apakah Anda yakin ingin membuat kartu santri ini?']); 
                        },
                        'riwayat' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, ['title' => 'Buat Kartu Riwayat Perpustakaan Kosong', 'data-confirm' => 'Apakah Anda yakin ingin membuat kartu riwayat perpustakaan kosong santri ini?']); 
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <form enctype="multipart/form-data" class="form-santri-csv" method="post" action="<?php echo Url::to(['santri/tambah-csv']); ?>" style="display: none">
        <input name="csv" type="file" class="upload-santri-csv" />
    </form>
</div>