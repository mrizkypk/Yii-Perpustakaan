<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
        <li role="presentation" class="active"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
    </ul>
</div>
<div class="col-md-10 content">
	<script type="text/javascript">
	$(function() {
		$('.restore-csv').click(function() {
			var mode = $(this).attr('id');
			$('.mode-restore-csv').val(mode);
			$('.upload-restore-csv').trigger('click');
			$('.upload-restore-csv').change(function() {
				$('.form-restore-csv').submit();
			});
		});
	});
	</script>
    <div class="site-pengaturan">
    <?php if (isset($_GET['denda'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Pengaturan denda berhasil diperbaharui.</b></h4>
	</div>
	<?php endif; ?>
    <?php if (isset($_GET['csv'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Semua data <?php echo $_GET['mode']; ?> berhasil direstore.</b></h4>
	</div>
	<?php endif; ?>
    <?php if (isset($_GET['buku'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Semua data buku berhasil dihapus.</b></h4>
	</div>
	<?php endif; ?>
	<?php if (isset($_GET['santri'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Semua data santri berhasil dihapus.</b></h4>
	</div>
	<?php endif; ?>
	<?php if (isset($_GET['bukutamu'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Semua data buku tamu berhasil dihapus.</b></h4>
	</div>
	<?php endif; ?>
	<?php if (isset($_GET['transaksi'])): ?>
	<div class="alert alert-success" role="alert">
		<h4><b>Semua data transaksi berhasil dihapus.</b></h4>
	</div>
	<?php endif; ?>

	<h3><span class="glyphicon glyphicon-book icon-blue" aria-hidden="true"></span> Buku</h3>
    <p>
		<?= Html::a('Buat Backup.CSV', ['buku-backup'], ['class' => 'btn btn-success']) ?>
		<button id="buku" class="restore-csv btn btn-blue">Restore Dari Berkas.CSV</button>
		<?= Html::a('Hapus Semua', ['buku-truncate'], ['class' => 'btn btn-warning', 'data-confirm' => 'Apakah Anda yakin ingin menghapus semua data buku?']) ?>
	</p>
	<hr>
	<h3><span class="glyphicon glyphicon-user icon-blue" aria-hidden="true"></span> Santri</h3>
    <p>
		<?= Html::a('Buat Backup.CSV', ['santri-backup'], ['class' => 'btn btn-success']) ?>
		<button id="santri" class="restore-csv btn btn-blue">Restore Dari Berkas.CSV</button>
		<?= Html::a('Hapus Semua', ['santri-truncate'], ['class' => 'btn btn-warning', 'data-confirm' => 'Apakah Anda yakin ingin menghapus semua data santri?']) ?>
	</p>
	<hr>
	<h3><span class="glyphicon glyphicon-bookmark icon-blue" aria-hidden="true"></span> Buku Tamu</h3>
    <p>
		<?= Html::a('Buat Backup.CSV', ['bukutamu-backup'], ['class' => 'btn btn-success']) ?>
		<button id="bukutamu" class="restore-csv btn btn-blue">Restore Dari Berkas.CSV</button>
		<?= Html::a('Hapus Semua', ['bukutamu-truncate'], ['class' => 'btn btn-warning', 'data-confirm' => 'Apakah Anda yakin ingin menghapus semua data buku tamu?']) ?>
	</p>
	<hr>
	<h3><span class="glyphicon glyphicon-refresh icon-blue" aria-hidden="true"></span> Transaksi</h3>
    <p>
		<?= Html::a('Buat Backup.CSV', ['transaksi-backup'], ['class' => 'btn btn-success']) ?>
		<button id="transaksi" class="restore-csv btn btn-blue">Restore Dari Berkas.CSV</button>
		<?= Html::a('Hapus Semua', ['transaksi-truncate'], ['class' => 'btn btn-warning', 'data-confirm' => 'Apakah Anda yakin ingin menghapus semua data transaksi?']) ?>
	</p>
	<hr>
	<h3><span class="glyphicon glyphicon-usd icon-blue" aria-hidden="true"></span> Denda</h3>
	<p>
		<form method="post" action="<?php echo Url::to(['site/pengaturan-denda']); ?>">
			<table>
				<tr>
					<td>Denda Per Hari</td>
					<td>:</td>
					<td><input type="text" name="denda_per_hari" value="<?php echo $model->denda_per_hari; ?>"></td>
				</tr>
				<tr>
					<td>Durasi Peminjaman Maksimal (Hari)</td>
					<td>:</td>
					<td><input type="text" name="maksimal_hari" value="<?php echo $model->maksimal_hari; ?>"></td>
				</tr>
			</table>
			<br>
			<button class="btn btn-info">Simpan Perubahan Denda</button>
		</form>
	</p>
    </div>

    <form enctype="multipart/form-data" class="form-restore-csv" method="post" action="<?php echo Url::to(['site/restore']); ?>" style="display: none">
        <input name="csv" type="file" class="upload-restore-csv" />
        <input name="mode" type="hidden" class="mode-restore-csv" />
    </form>
</div>