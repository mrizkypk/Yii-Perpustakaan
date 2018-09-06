<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Transaksi */

$this->title = 'Cetak Riwayat Transaksi';
$this->params['breadcrumbs'][] = ['label' => 'Transaksi', 'url' => ['index']];
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
    <div class="transaksi-cetak">
	<script type="text/javascript">
	$(function() {
		$('.tandai').click(function(){
			$(this).parent().parent().parent().find('td:eq(0)').toggleClass('tertandai');
			$(this).parent().parent().parent().find('td:eq(1)').toggleClass('tertandai');
            $(this).parent().parent().parent().find('td:eq(2)').toggleClass('tertandai');
            $(this).parent().parent().parent().find('td:eq(3)').toggleClass('tertandai');
			$(this).parent().parent().parent().find('td:eq(4)').toggleClass('tertandai');
		});

		$('td').click(function(){
			if ($(this).index() < 5) {
				$(this).toggleClass('tertandai');
			}
		})

        $('.cetak').click(function(){
            $('tr').each(function(index) {
                if (index > 0) {
                    var judul = $(this).find('td:eq(0)');
                    var pengarang = $(this).find('td:eq(1)');
                    var tanggal_peminjaman = $(this).find('td:eq(2)');
                    var tanggal_pengembalian = $(this).find('td:eq(3)');
                    var denda = $(this).find('td:eq(4)');
                    if (judul != false && judul.hasClass('tertandai') == true) {
                        $('.buku_' + index).val(judul.html());
                    } else {
                        $('.buku_' + index).val('');
                    }
                    if (pengarang != false && pengarang.hasClass('tertandai') == true) {
                        $('.pengarang_' + index).val(pengarang.html());
                    } else {
                        $('.pengarang_' + index).val('');
                    }
                    if (tanggal_peminjaman != false && tanggal_peminjaman.hasClass('tertandai') == true) {
                        $('.tanggal_peminjaman_' + index).val(tanggal_peminjaman.html());
                    } else {
                        $('.tanggal_peminjaman_' + index).val('');
                    }
                    if (tanggal_pengembalian != false && tanggal_pengembalian.hasClass('tertandai') == true) {
                        $('.tanggal_pengembalian_' + index).val(tanggal_pengembalian.html());
                    } else {
                        $('.tanggal_pengembalian_' + index).val('');
                    }
                    if (denda != false && denda.hasClass('tertandai') == true) {
                        $('.denda_' + index).val(denda.html());
                    } else {
                        $('.denda_' + index).val('');
                    }
                }
            });
            $('.form_cetak').submit();     
        });
    });
    </script>
    <?php if ($santri != false): ?>
    <h3>Riwayat Transaksi: <?php echo $santri; ?></h3>
    <button type="button" class="cetak btn btn-success">
    Cetak
    </button>
	<?php endif; ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'buku_judul',
                    'value' => 'buku.judul'
                ],
                [
                    'attribute' => 'buku_pengarang',
                    'value' => 'buku.pengarang'
                ],
                [
                    'label' => 'Tanggal Peminjaman',
                    'attribute' => 'tanggal_peminjaman',
                    'value' => function ($model) {
                        return $model->getTanggalPeminjamanSingkat();
                    }
                ],
                [
                    'label' => 'Tanggal Pengembalian',
                    'attribute' => 'tanggal_pengembalian',
                    'value' => function ($model) {
                        return $model->getTanggalPengembalianSingkat();
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
                    'template' => '<center>{tandai}</center>',
                    'buttons' => [
                        'tandai' => function(){
                        	return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '#', ['class' => 'tandai', 'title' => 'Tandai']);
                        }
                    ],
                ],
            ],
        ]); ?>

        <form method="post" action="<?php echo Url::home(true); ?>riwayat.php" class="form_cetak">
            <input type="hidden" name="cetak">
            <?php if ($santri != false && $nis != false): ?>
            <input type="hidden" name="nama" value="<?php echo $santri; ?>">
            <input type="hidden" name="nis" value="<?php echo $nis; ?>">
            <?php endif; ?>
            <input type="hidden" name="buku_1" class="buku_1">
            <input type="hidden" name="buku_2" class="buku_2">
            <input type="hidden" name="buku_3" class="buku_3">
            <input type="hidden" name="buku_4" class="buku_4">
            <input type="hidden" name="buku_5" class="buku_5">
            <input type="hidden" name="buku_6" class="buku_6">
            <input type="hidden" name="buku_7" class="buku_7">
            <input type="hidden" name="buku_8" class="buku_8">
            <input type="hidden" name="buku_9" class="buku_9">
            <input type="hidden" name="buku_10" class="buku_10">
            <input type="hidden" name="buku_11" class="buku_11">
            <input type="hidden" name="buku_12" class="buku_12">
            <input type="hidden" name="buku_13" class="buku_13">
            <input type="hidden" name="buku_14" class="buku_14">
            <input type="hidden" name="buku_15" class="buku_15">
            <input type="hidden" name="pengarang_1" class="pengarang_1">
            <input type="hidden" name="pengarang_2" class="pengarang_2">
            <input type="hidden" name="pengarang_3" class="pengarang_3">
            <input type="hidden" name="pengarang_4" class="pengarang_4">
            <input type="hidden" name="pengarang_5" class="pengarang_5">
            <input type="hidden" name="pengarang_6" class="pengarang_6">
            <input type="hidden" name="pengarang_7" class="pengarang_7">
            <input type="hidden" name="pengarang_8" class="pengarang_8">
            <input type="hidden" name="pengarang_9" class="pengarang_9">
            <input type="hidden" name="pengarang_10" class="pengarang_10">
            <input type="hidden" name="pengarang_11" class="pengarang_11">
            <input type="hidden" name="pengarang_12" class="pengarang_12">
            <input type="hidden" name="pengarang_13" class="pengarang_13">
            <input type="hidden" name="pengarang_14" class="pengarang_14">
            <input type="hidden" name="pengarang_15" class="pengarang_15">
            <input type="hidden" name="tanggal_peminjaman_1" class="tanggal_peminjaman_1">
            <input type="hidden" name="tanggal_peminjaman_2" class="tanggal_peminjaman_2">
            <input type="hidden" name="tanggal_peminjaman_3" class="tanggal_peminjaman_3">
            <input type="hidden" name="tanggal_peminjaman_4" class="tanggal_peminjaman_4">
            <input type="hidden" name="tanggal_peminjaman_5" class="tanggal_peminjaman_5">
            <input type="hidden" name="tanggal_peminjaman_6" class="tanggal_peminjaman_6">
            <input type="hidden" name="tanggal_peminjaman_7" class="tanggal_peminjaman_7">
            <input type="hidden" name="tanggal_peminjaman_8" class="tanggal_peminjaman_8">
            <input type="hidden" name="tanggal_peminjaman_9" class="tanggal_peminjaman_9">
            <input type="hidden" name="tanggal_peminjaman_10" class="tanggal_peminjaman_10">
            <input type="hidden" name="tanggal_peminjaman_11" class="tanggal_peminjaman_11">
            <input type="hidden" name="tanggal_peminjaman_12" class="tanggal_peminjaman_12">
            <input type="hidden" name="tanggal_peminjaman_13" class="tanggal_peminjaman_13">
            <input type="hidden" name="tanggal_peminjaman_14" class="tanggal_peminjaman_14">
            <input type="hidden" name="tanggal_peminjaman_15" class="tanggal_peminjaman_15">
            <input type="hidden" name="tanggal_pengembalian_1" class="tanggal_pengembalian_1">
            <input type="hidden" name="tanggal_pengembalian_2" class="tanggal_pengembalian_2">
            <input type="hidden" name="tanggal_pengembalian_3" class="tanggal_pengembalian_3">
            <input type="hidden" name="tanggal_pengembalian_4" class="tanggal_pengembalian_4">
            <input type="hidden" name="tanggal_pengembalian_5" class="tanggal_pengembalian_5">
            <input type="hidden" name="tanggal_pengembalian_6" class="tanggal_pengembalian_6">
            <input type="hidden" name="tanggal_pengembalian_7" class="tanggal_pengembalian_7">
            <input type="hidden" name="tanggal_pengembalian_8" class="tanggal_pengembalian_8">
            <input type="hidden" name="tanggal_pengembalian_9" class="tanggal_pengembalian_9">
            <input type="hidden" name="tanggal_pengembalian_10" class="tanggal_pengembalian_10">
            <input type="hidden" name="tanggal_pengembalian_11" class="tanggal_pengembalian_11">
            <input type="hidden" name="tanggal_pengembalian_12" class="tanggal_pengembalian_12">
            <input type="hidden" name="tanggal_pengembalian_13" class="tanggal_pengembalian_13">
            <input type="hidden" name="tanggal_pengembalian_14" class="tanggal_pengembalian_14">
            <input type="hidden" name="tanggal_pengembalian_15" class="tanggal_pengembalian_15">
            <input type="hidden" name="denda_1" class="denda_1">
            <input type="hidden" name="denda_2" class="denda_2">
            <input type="hidden" name="denda_3" class="denda_3">
            <input type="hidden" name="denda_4" class="denda_4">
            <input type="hidden" name="denda_5" class="denda_5">
            <input type="hidden" name="denda_6" class="denda_6">
            <input type="hidden" name="denda_7" class="denda_7">
            <input type="hidden" name="denda_8" class="denda_8">
            <input type="hidden" name="denda_9" class="denda_9">
            <input type="hidden" name="denda_10" class="denda_10">
            <input type="hidden" name="denda_11" class="denda_11">
            <input type="hidden" name="denda_12" class="denda_12">
            <input type="hidden" name="denda_13" class="denda_13">
            <input type="hidden" name="denda_14" class="denda_14">
            <input type="hidden" name="denda_15" class="denda_15">
        </form>
    </div>
</div>