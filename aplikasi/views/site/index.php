<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Beranda';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation" class="active"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
		<li role="presentation"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
    </ul>
</div>
<div class="col-md-10 content">
    <div class="site-index">
    <p>
		<div class="dropdown">
		  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Pilih Tahun
		  <span class="caret"></span></button>
		  <ul class="dropdown-menu">
		  	<?php foreach ($tahuns as $t): ?>
		    <li><a href="<?php echo Url::to(['site/index', 'tahun' => $t]); ?>"><?php echo $t; ?></a></li>
			<?php endforeach; ?>
		  </ul>
		</div>
		<?= Html::a('Unduh Laporan Tahunan', ['export', 'tahun' => $tahun], ['class' => 'btn btn-success']) ?>
	</p>
	<h4 class="text-center">LAPORAN TAHUN <?php echo $tahun; ?></h4>
    <script type="text/javascript" src="<?php echo Url::home(true); ?>js/chart.bundle.js"></script>
		<canvas id="myChart" width="400" height="200"></canvas>
		<script>
		var ctx = document.getElementById("myChart");
		var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
		        datasets: [{
		            label: 'Pengunjung',
		            data: [<?php echo implode(',', $pengunjung); ?>],
		            backgroundColor: "#FF5722",
                    borderColor: "#FF5722",
		            borderWidth: 1
		        },{
		            label: 'Peminjaman',
		            data: [<?php echo implode(',', $peminjaman); ?>],
		            backgroundColor: "#2196F3",
                    borderColor: "#2196F3",
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero:true
		                }
		            }]
		        }
		    }
		});
		</script>
    </div>
</div>