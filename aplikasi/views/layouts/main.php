<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo Url::home(true); ?>favicon.png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script type="text/javascript" src="<?php echo Url::home(true); ?>js/jquery.js"></script>
    <?php $this->head() ?>
</head>
<body>
<div class="container-fluid">
<?php $this->beginBody() ?>
    <?= $content ?>
<?php $this->endBody() ?>
</div>
</body>
<script type="text/javascript">
$(function() {
	$('.tambah-buku-csv').click(function() {
		$('.upload-buku-csv').trigger('click');
		$('.upload-buku-csv').change(function() {
			$('.form-buku-csv').submit();
		});
	});

	$('.tambah-santri-csv').click(function() {
		$('.upload-santri-csv').trigger('click');
		$('.upload-santri-csv').change(function() {
			$('.form-santri-csv').submit();
		});
	});

	<?php if (isset($_GET['notifikasi'])): ?>
	$('table').find('tbody tr:first').addClass('flash');
	<?php endif; ?>

	function playSound() {
		var audio = new Audio('<?php echo Url::home(true); ?>beep.mp3');
		audio.play();
	}

	$('#myModal').on('hidden.bs.modal', function (e) {
		$('.form-tambah').show();
		$('.scan-buku').show();
		$('.scan-kartu').show();
		$('.scan-hasil').show();

		$('.form-pengembalian').show();
		$('.scan-buku2').show();
		$('.scan-kartu2').show();
		$('.scan-hasil2').show();
	});

	$('#myModal2').on('hidden.bs.modal', function (e) {
		$('.form-pengembalian').show();
		$('.scan-buku2').show();
		$('.scan-kartu2').show();
		$('.scan-hasil2').show();
	});


	$('#myModal3').on('hidden.bs.modal', function (e) {
		$('.scan-kartu3').hide();
	});

	$('#myModal').on('show.bs.modal', function (e) {
		$('.form-tambah').hide();
		$('.scan-hasil').hide();
		$('.scan-buku').hide();

		$('.form-pengembalian').hide();
		$('.scan-hasil2').hide();
		$('.scan-buku2').hide();
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
	                    if ($('.scan-buku').is(':hidden') && $('.scan-kartu').is(':visible')) {
	                    	$.get("<?php echo Url::to(['transaksi/santri']); ?>?nis=" + barcode, function(data, status) {
	                    		var json = JSON.parse(data);
						        $('.nama-santri').text(json.nama);
						        $('#transaksi-santri_id').val(json.id);
						        if (json.nama != 'SANTRI TIDAK TERDAFTAR') {
									$('.scan-buku').show();
								} else {
									$('.scan-hasil').show();
								}
								$('.scan-kartu').hide();
								playSound();
						    });		
	                    }

	                    if ($('.scan-buku').is(':visible') && $('.scan-kartu').is(':hidden')) {
	                    	$.get("<?php echo Url::to(['transaksi/buku']); ?>?isbn=" + barcode, function(data, status) {
								var json = JSON.parse(data);
								$('.judul-buku').text(json.judul);
								$('#transaksi-buku_id').val(json.id);
								$('.scan-buku').hide();
								$('.scan-hasil').show();
								if (json.judul != 'BUKU TIDAK TERDAFTAR') {
									$('.form-tambah').show();
								}
								playSound();
						    });		
	                    }
	                }
	                chars = [];
	                pressed = false;
	            },500);
	        }
	        pressed = true;
	    });
	});

	$('#myModal2').on('show.bs.modal', function (e) {
		$('.form-tambah').hide();
		$('.scan-hasil').hide();
		$('.scan-buku').hide();

		$('.form-pengembalian').hide();
		$('.scan-hasil2').hide();
		$('.scan-buku2').hide();
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
	                    if ($('.scan-buku2').is(':hidden') && $('.scan-kartu2').is(':visible')) {
	                    	$.get("<?php echo Url::to(['transaksi/santri']); ?>?nis=" + barcode, function(data, status) {
	                    		var json = JSON.parse(data);
						        $('.nama-santri2').text(json.nama);
						        $('#transaksi-santri_id2').val(json.id);
								$('.scan-buku2').show();
								$('.scan-kartu2').hide();
								playSound();
						    });		
	                    }

						if ($('.scan-buku2').is(':visible') && $('.scan-kartu2').is(':hidden')) {
	                    	$.get("<?php echo Url::to(['transaksi/buku2']); ?>?isbn=" + barcode, function(data, status) {
								var json = JSON.parse(data);
								$('.judul-buku2').text(json.judul);
								$('#transaksi-buku_id2').val(json.id);
								$('.scan-buku2').hide();
								$('.scan-hasil2').show();
								$('.form-pengembalian').show();
								playSound();
						    });		
	                    }
	                }
	                chars = [];
	                pressed = false;
	            },500);
	        }
	        pressed = true;
	    });
	});

	$('#myModal3').on('show.bs.modal', function (e) {
		$('.scan-kartu3').show();
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
	                    if ($('.scan-kartu3').is(':visible')) {
						playSound();
	                    	$.get("<?php echo Url::to(['transaksi/santri']); ?>?nis=" + barcode, function(data, status) {
	                    		var json = JSON.parse(data);
						        window.location = '<?php echo Url::to(['transaksi/cetak']); ?>?sort=tanggal_peminjaman&TransaksiSearch[santri_id]=' + json.id;
						    });		
	                    }
	                }
	                chars = [];
	                pressed = false;
	            },500);
	        }
	        pressed = true;
	    });
	});
});
</script>
</html>
<?php $this->endPage() ?>