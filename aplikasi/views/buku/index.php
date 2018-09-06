<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BukuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-2 navbar-left">
    <ul class="nav nav nav-pills nav-stacked">
        <li role="presentation"><a href="<?php echo Url::to(['site/index']); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Beranda</a></li>
        <li role="presentation" class="active"><a href="<?php echo Url::to(['buku/index']); ?>"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Buku</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['santri/index']); ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Santri</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['buku-tamu/index']); ?>"><span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span> Buku Tamu</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['transaksi/index']); ?>"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Transaksi</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/pengaturan']); ?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Pengaturan</a></li>
        <li role="presentation"><a href="<?php echo Url::to(['site/keluar']); ?>"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Keluar</a></li>
    </ul>
</div>
<div class="col-md-10 content">
    <div class="buku-index">
        <?php if (isset($_GET['csv'])): ?>
            <div class="alert alert-success" role="alert">
                <h4><b>Semua data buku dari berkas csv berhasil dibuat!</b></h4>
            </div>
        <?php endif; ?>
        <?php if (isset($_GET['barcode'])): ?>
            <div class="alert alert-success" role="alert">
                <h4><b>Semua barcode buku berhasil dibuat!</b></h4>
                <br>
                Silahkan buka <b>Windows Explorer</b> ke alamat ini:
                <br><br>
                <b><i><?php echo dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR; ?>barcode<?php echo DIRECTORY_SEPARATOR; ?>buku</i></b>
            </div>
        <?php endif; ?>
        <p>
            <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            <button class="tambah-buku-csv btn btn-warning">Tambah Dari Berkas.CSV</button>
            <?= Html::a('Buat Semua Barcode Buku', ['semua-barcode'], ['class' => 'btn btn-blue']) ?>
        </p>
        <?php Pjax::begin(['id' => 'buku']) ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'isbn',
                    'label' => 'ISBN'
                ],
                'pengarang',
                'judul',
                'penerbit',
                [
                    'label' => 'Stok',
                    'attribute' => 'stok',
                    'value' => function ($model) {
                        return $model->sisa();
                    }
                 ],
                'kategori',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '<center>{barcode} {update} {delete}</center>',
                    'buttons' => [
                        'barcode' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-barcode"></span>', $url, ['title' => 'Buat Barcode', 'data-confirm' => 'Apakah Anda yakin ingin membuat barcode buku ini?']); 
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
    <form enctype="multipart/form-data" class="form-buku-csv" method="post" action="<?php echo Url::to(['buku/tambah-csv']); ?>" style="display: none">
        <input name="csv" type="file" class="upload-buku-csv" />
    </form>
</div>