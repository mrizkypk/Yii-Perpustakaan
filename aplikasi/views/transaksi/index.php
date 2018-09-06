<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TransaksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaksi';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation" class="active"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
    </ul>
</div>

<div class="col-md-10 content">
    <div class="transaksi-index">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
          Peminjaman
        </button>

        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal2">
          Pengembalian
        </button>

        <button type="button" class="btn btn-blue" data-toggle="modal" data-target="#myModal3">
          Cetak Riwayat
        </button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Peminjaman</h4>
              </div>
              <div class="modal-body text-center">
                <span class="scan-kartu">
                    <img src="<?php echo Url::home(true); ?>barcode-scan.gif">
                    <br>
                    <div class="alert alert-success" role="alert"><h3 class="text-white"><b>Scan Barcode Kartu Santri</b></h3></div>
                </span>
                <span class="scan-buku">
                    <img src="<?php echo Url::home(true); ?>barcode-scan.gif">
                    <br>
                    <div class="alert alert-warning" role="alert"><h3 class="text-white"><b>Scan Barcode Buku</b></h3></div>
                </span>
                <span class="scan-hasil">
                    <h4><b>Nama</b>: <span class="nama-santri"></span></h4>
                    <h4><b>Judul Buku</b>: <span class="judul-buku"></span></h4>
                </span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default close-button" data-dismiss="modal">Tutup</button>
                <form class="form-tambah" action="<?php echo Url::to(['transaksi/create']); ?>" method="post" style="display: inline">
                    <input type="hidden" id="transaksi-buku_id" name="Transaksi[buku_id]">
                    <input type="hidden" id="transaksi-santri_id" name="Transaksi[santri_id]">
                    <button type="submit" class="btn btn-success">Tambah</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal 2 -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Pengembalian</h4>
              </div>
              <div class="modal-body text-center">
                <span class="scan-kartu2">
                    <img src="<?php echo Url::home(true); ?>barcode-scan.gif">
                    <br>
                    <div class="alert alert-success" role="alert"><h3 class="text-white"><b>Scan Barcode Kartu Santri</b></h3></div>
                </span>
                <span class="scan-buku2">
                    <img src="<?php echo Url::home(true); ?>barcode-scan.gif">
                    <br>
                    <div class="alert alert-warning" role="alert"><h3 class="text-white"><b>Scan Barcode Buku</b></h3></div>
                </span>
                <span class="scan-hasil2">
                    <h4><b>Nama</b>: <span class="nama-santri2"></span></h4>
                    <h4><b>Judul Buku</b>: <span class="judul-buku2"></span></h4>
                </span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default close-button" data-dismiss="modal">Tutup</button>
                <form class="form-pengembalian" action="<?php echo Url::to(['transaksi/pengembalian2']); ?>" method="post" style="display: inline">
                    <input type="hidden" id="transaksi-buku_id2" name="transaksi-buku_id2">
                    <input type="hidden" id="transaksi-santri_id2" name="transaksi-santri_id2">
                    <button type="submit" class="btn btn-success">Terima Pengembalian</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal 3 -->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Cetak Riwayat</h4>
              </div>
              <div class="modal-body text-center">
                <span class="scan-kartu3">
                    <img src="<?php echo Url::home(true); ?>barcode-scan.gif">
                    <br>
                    <div class="alert alert-success" role="alert"><h3 class="text-white"><b>Scan Barcode Kartu Santri</b></h3></div>
                </span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default close-button" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>

        <?php Pjax::begin(['id' => 'transaksi']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'buku_judul',
                    'value' => 'buku.judul'
                ],
                [
                    'attribute' => 'santri_nama',
                    'value' => 'santri.nama'
                ],
                [
                    'label' => 'Tanggal Peminjaman',
                    'attribute' => 'tanggal_peminjaman',
                    'value' => function ($model) {
                        return $model->getTanggalPeminjaman();
                    }
                ],
                [
                    'label' => 'Tanggal Pengembalian',
                    'attribute' => 'tanggal_pengembalian',
                    'value' => function ($model) {
                        return $model->getTanggalPengembalian();
                    }
                ],
                [
                    'label' => 'Denda',
                    'attribute' => 'tanggal_pengembalian',
                    'value' => function ($model) {
                        return $model->getDenda();
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<center>{pengembalian} {riwayat} {delete}</center>',
                    'buttons' => [
                        'pengembalian' => function ($url, $model) {
                            return ($model->tanggal_pengembalian == null ? Html::a('<span class="glyphicon glyphicon-check"></span>', $url, ['title' => 'Pengembalian', 'data-confirm' => 'Apakah Anda yakin ingin mengubah status item ini menjadi sudah dikembalikan?']) : ''); 
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>