<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Buku;
use app\models\BukuTamu;
use app\models\Santri;
use app\models\Transaksi;
use app\models\Pengaturan;
use app\libraries\Csv;
use yii\helpers\Url;

class SiteController extends CController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
        } else {
            $tahun = date('Y');
        }
        $queriesPengunjung = [];
        $queriesPeminjaman = [];
        for ($i =1 ; $i < 13; $i++) {
            $i2 = $i + 1;
            if ($i < 10) {
                $i = '0'. $i;
            } 
            if ($i2 < 10) {
                $i2 = '0'. $i2;
            }

            $queriesPengunjung[] = Yii::$app->db->createCommand("
            SELECT COUNT(DISTINCT santri_id) AS jumlah FROM buku_tamu 
            WHERE tanggal >= UNIX_TIMESTAMP('" . $tahun . "-" . $i . "-01')
            AND tanggal < UNIX_TIMESTAMP('" . $tahun. "-" . $i2. "-01')")
            ->queryOne();

            $queriesPeminjaman[] = Yii::$app->db->createCommand("
            SELECT COUNT(id) AS jumlah FROM transaksi 
            WHERE tanggal_peminjaman >= UNIX_TIMESTAMP('" . $tahun . "-" . $i . "-01')
            AND tanggal_peminjaman < UNIX_TIMESTAMP('" . $tahun. "-" . $i2. "-01')")
            ->queryOne();
        }


        $pengunjung = [
            'januari' => $queriesPengunjung[0]['jumlah'],
            'februari' => $queriesPengunjung[1]['jumlah'],
            'maret' => $queriesPengunjung[2]['jumlah'],
            'april' => $queriesPengunjung[3]['jumlah'],
            'mei' => $queriesPengunjung[4]['jumlah'],
            'juni' => $queriesPengunjung[5]['jumlah'],
            'juli' => $queriesPengunjung[6]['jumlah'],
            'agustus' => $queriesPengunjung[7]['jumlah'],
            'september' => $queriesPengunjung[8]['jumlah'],
            'oktober' => $queriesPengunjung[9]['jumlah'],
            'november' => $queriesPengunjung[10]['jumlah'],
            'desember' => $queriesPengunjung[11]['jumlah'],
        ];

        $peminjaman = [
            'januari' => $queriesPeminjaman[0]['jumlah'],
            'februari' => $queriesPeminjaman[1]['jumlah'],
            'maret' => $queriesPeminjaman[2]['jumlah'],
            'april' => $queriesPeminjaman[3]['jumlah'],
            'mei' => $queriesPeminjaman[4]['jumlah'],
            'juni' => $queriesPeminjaman[5]['jumlah'],
            'juli' => $queriesPeminjaman[6]['jumlah'],
            'agustus' => $queriesPeminjaman[7]['jumlah'],
            'september' => $queriesPeminjaman[8]['jumlah'],
            'oktober' => $queriesPeminjaman[9]['jumlah'],
            'november' => $queriesPeminjaman[10]['jumlah'],
            'desember' => $queriesPeminjaman[11]['jumlah'],
        ];

        $tahuns = range(2017, 2027);


        return $this->render('index', [
            'tahun' => $tahun,
            'tahuns' => $tahuns,
            'pengunjung' => $pengunjung,
            'peminjaman' => $peminjaman,
        ]);
    }

    public function getCsvValue($array, $key) {
        if (isset($array[$key])) {
            return $array[$key];
        } else {
            return '';
        }
    }

    public function actionExport() {
        if (isset($_GET['tahun'])) {
            $tahun = $_GET['tahun'];
            $tahun2 = $_GET['tahun'];
        } else {
            $tahun = date('Y');
            $tahun2 = date('Y');
        }
        $namafile = 'LAPORAN PERPUSTAKAAN TAHUN '. $tahun . '.csv';
        ob_clean();
        header("Content-type: text/x-csv");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename="' . $namafile . '"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $max = 0 ;
        $data['januari'] = [];
        $data['februari'] = [];
        $data['maret'] = [];
        $data['april'] = [];
        $data['mei'] = [];
        $data['juni'] = [];
        $data['juli'] = [];
        $data['agustus'] = [];
        $data['september'] = [];
        $data['oktober'] = [];
        $data['november'] = [];
        $data['desember'] = [];

        $queries= Yii::$app->db->createCommand("
            SELECT santri.nama AS santri, buku_tamu.tanggal as tanggal FROM buku_tamu JOIN santri
            ON buku_tamu.santri_id = santri.id")
            ->queryAll();

        foreach ($queries as $query) {
            $tanggal = $query['tanggal'];
            if ($tanggal >= strtotime('' . $tahun . '-01-01') && $tanggal <strtotime('' . $tahun . '-02-01')) {
                $data['januari'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-02-01') && $tanggal <strtotime('' . $tahun . '-03-01')) {
                $data['februari'][] = $query['santri'];
             }
            if ($tanggal >= strtotime('' . $tahun . '-03-01') && $tanggal <strtotime('' . $tahun . '-04-01')) {
                $data['maret'][] = $query['santri'];
            } 
            if ($tanggal >= strtotime('' . $tahun . '-04-01') && $tanggal <strtotime('' . $tahun . '-05-01')) {
                $data['april'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-05-01') && $tanggal <strtotime('' . $tahun . '-06-01')) {
                $data['mei'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-06-01') && $tanggal <strtotime('' . $tahun . '-07-01')) {
                $data['juni'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-07-01') && $tanggal <strtotime('' . $tahun . '-08-01')) {
                $data['juli'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-08-01') && $tanggal <strtotime('' . $tahun . '-09-01')) {
                $data['agustus'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-09-01') && $tanggal <strtotime('' . $tahun . '-10-01')) {
                $data['september'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-10-01') && $tanggal <strtotime('' . $tahun . '-11-01')) {
                $data['oktober'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-11-01') && $tanggal <strtotime('' . $tahun . '-12-01')) {
                $data['november'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun . '-12-01') && $tanggal <strtotime('' . $tahun + 1 . '-01-01')) {
                $data['desember'][] = $query['santri'];
            }
        }

        foreach ($data as $key => $value) {
            $data[$key] = array_values(array_unique($data[$key]));
            if (count($data[$key]) >= $max) {
                $max = count($data[$key]);
            }
        }
        echo 'LAPORAN PENGUNJUNG PERPUSTAKAAN TAHUN ' . $tahun . ' (Nama Santri)';
        echo "\n\r";
        echo implode(',', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        echo "\n";
        for ($i=0; $i < $max; $i++) { 
            echo $this->getCsvValue($data['januari'], $i) . ',' . 
            $this->getCsvValue($data['februari'], $i) . ',' . 
            $this->getCsvValue($data['maret'], $i) . ',' . 
            $this->getCsvValue($data['april'], $i) . ',' . 
            $this->getCsvValue($data['mei'], $i) . ',' . 
            $this->getCsvValue($data['juni'], $i) . ',' . 
            $this->getCsvValue($data['juli'], $i) . ',' . 
            $this->getCsvValue($data['agustus'], $i) . ',' . 
            $this->getCsvValue($data['september'], $i) . ',' . 
            $this->getCsvValue($data['oktober'], $i) . ',' . 
            $this->getCsvValue($data['november'], $i) . ',' . 
            $this->getCsvValue($data['desember'], $i);
            echo "\n";
        }
        echo 'LAPORAN PENGUNJUNG PERPUSTAKAAN TAHUN ' . $tahun . ' (Jumlah Santri)';
        echo "\n\r";
        echo implode(',', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        echo "\n";
        echo count($data['januari']) . ',' . 
        count($data['februari']) . ',' . 
        count($data['maret']) . ',' . 
        count($data['april']) . ',' . 
        count($data['mei']) . ',' . 
        count($data['juni']) . ',' . 
        count($data['juli']) . ',' . 
        count($data['agustus']) . ',' . 
        count($data['september']) . ',' . 
        count($data['oktober']) . ',' . 
        count($data['november']) . ',' . 
        count($data['desember']);
        echo "\n";

        $max2 = 0 ;
        $data2['januari'] = [];
        $data2['februari'] = [];
        $data2['maret'] = [];
        $data2['april'] = [];
        $data2['mei'] = [];
        $data2['juni'] = [];
        $data2['juli'] = [];
        $data2['agustus'] = [];
        $data2['september'] = [];
        $data2['oktober'] = [];
        $data2['november'] = [];
        $data2['desember'] = [];

        $data3['januari'] = [];
        $data3['februari'] = [];
        $data3['maret'] = [];
        $data3['april'] = [];
        $data3['mei'] = [];
        $data3['juni'] = [];
        $data3['juli'] = [];
        $data3['agustus'] = [];
        $data3['september'] = [];
        $data3['oktober'] = [];
        $data3['november'] = [];
        $data3['desember'] = [];

        $queries2 = Yii::$app->db->createCommand("
            SELECT santri.nama AS santri, transaksi.tanggal_peminjaman as tanggal FROM transaksi JOIN santri
            ON transaksi.santri_id = santri.id")
            ->queryAll();


        foreach ($queries2 as $query) {
            $tanggal = $query['tanggal'];
            if ($tanggal >= strtotime('' . $tahun2 . '-01-01') && $tanggal <strtotime('' . $tahun2 . '-02-01')) {
                $data2['januari'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-02-01') && $tanggal <strtotime('' . $tahun2 . '-03-01')) {
                $data2['februari'][] = $query['santri'];
             }
            if ($tanggal >= strtotime('' . $tahun2 . '-03-01') && $tanggal <strtotime('' . $tahun2 . '-04-01')) {
                $data2['maret'][] = $query['santri'];
            } 
            if ($tanggal >= strtotime('' . $tahun2 . '-04-01') && $tanggal <strtotime('' . $tahun2 . '-05-01')) {
                $data2['april'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-05-01') && $tanggal <strtotime('' . $tahun2 . '-06-01')) {
                $data2['mei'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-06-01') && $tanggal <strtotime('' . $tahun2 . '-07-01')) {
                $data2['juni'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-07-01') && $tanggal <strtotime('' . $tahun2 . '-08-01')) {
                $data2['juli'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-08-01') && $tanggal <strtotime('' . $tahun2 . '-09-01')) {
                $data2['agustus'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-09-01') && $tanggal <strtotime('' . $tahun2 . '-10-01')) {
                $data2['september'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-10-01') && $tanggal <strtotime('' . $tahun2 . '-11-01')) {
                $data2['oktober'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-11-01') && $tanggal <strtotime('' . $tahun2 . '-12-01')) {
                $data2['november'][] = $query['santri'];
            }
            if ($tanggal >= strtotime('' . $tahun2 . '-12-01') && $tanggal <strtotime('' . $tahun2 + 1 . '-01-01')) {
                $data2['desember'][] = $query['santri'];
            }
        }

        foreach ($data2 as $key => $value) {
            $data3[$key] = $data2[$key];
            $data2[$key] = array_values(array_unique($data2[$key]));
            if (count($data2[$key]) >= $max2) {
                $max2 = count($data2[$key]);
            }
        }

        echo "\n\r";
        echo "\n\r";
        echo 'LAPORAN PEMINJAMAN BUKU PERPUSTAKAAN TAHUN ' . $tahun2 . ' (Nama Santri)';
        echo "\n\r";
        echo implode(',', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        echo "\n";
        for ($i=0; $i < $max2; $i++) { 
            echo $this->getCsvValue($data2['januari'], $i) . ',' . 
            $this->getCsvValue($data2['februari'], $i) . ',' . 
            $this->getCsvValue($data2['maret'], $i) . ',' . 
            $this->getCsvValue($data2['april'], $i) . ',' . 
            $this->getCsvValue($data2['mei'], $i) . ',' . 
            $this->getCsvValue($data2['juni'], $i) . ',' . 
            $this->getCsvValue($data2['juli'], $i) . ',' . 
            $this->getCsvValue($data2['agustus'], $i) . ',' . 
            $this->getCsvValue($data2['september'], $i) . ',' . 
            $this->getCsvValue($data2['oktober'], $i) . ',' . 
            $this->getCsvValue($data2['november'], $i) . ',' . 
            $this->getCsvValue($data2['desember'], $i);
            echo "\n";
        }
        echo 'LAPORAN PEMINJAMAN BUKU PERPUSTAKAAN TAHUN ' . $tahun2 . ' (Jumlah Santri)';
        echo "\n\r";
        echo implode(',', ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']);
        echo "\n";
        echo count($data3['januari']) . ',' . 
        count($data3['februari']) . ',' . 
        count($data3['maret']) . ',' . 
        count($data3['april']) . ',' . 
        count($data3['mei']) . ',' . 
        count($data3['juni']) . ',' . 
        count($data3['juli']) . ',' . 
        count($data3['agustus']) . ',' . 
        count($data3['september']) . ',' . 
        count($data3['oktober']) . ',' . 
        count($data3['november']) . ',' . 
        count($data3['desember']);
        echo "\n";
        die();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionPengaturan()
    {
        return $this->render('pengaturan', [
            'model' => Pengaturan::findOne(1)
        ]);
    }

    public function actionBukuBackup()
    {
        $namafile = 'BACKUP DATA BUKU '. date('d-m-Y') . '.csv';
        ob_clean();
        header("Content-type: text/x-csv");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename="' . $namafile . '"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $queries = Yii::$app->db->createCommand("SELECT * FROM buku")->queryAll();
        foreach ($queries as $query) {
            echo $query['isbn'] . ',' . 
            '"' . $query['pengarang'] . '",' . 
            '"' . $query['judul'] . '",' . 
            '"' . $query['penerbit'] . '",' . 
            $query['stok'] . ',' . 
            '"' . $query['kategori'] . '"';
            echo "\n";
        }
        die();
    }

    public function actionSantriBackup()
    {
        $namafile = 'BACKUP DATA SANTRI '. date('d-m-Y') . '.csv';
        ob_clean();
        header("Content-type: text/x-csv");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename="' . $namafile . '"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $queries = Yii::$app->db->createCommand("SELECT * FROM santri")->queryAll();
        foreach ($queries as $query) {
            echo $query['nis'] . ',' . 
            '"' . $query['nama'] . '"';
            echo "\n";
        }
        die();
    }


    public function actionBukutamuBackup()
    {
        $namafile = 'BACKUP DATA BUKU TAMU '. date('d-m-Y') . '.csv';
        ob_clean();
        header("Content-type: text/x-csv");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename="' . $namafile . '"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $queries = Yii::$app->db->createCommand("SELECT * FROM buku_tamu")->queryAll();
        foreach ($queries as $query) {
            echo $query['santri_id'] . ',' . 
            '"' . $query['tanggal'] . '"';
            echo "\n";
        }
        die();
    }

    public function actionTransaksiBackup()
    {
        $namafile = 'BACKUP DATA TRANSAKSI '. date('d-m-Y') . '.csv';
        ob_clean();
        header("Content-type: text/x-csv");
        header("Content-Transfer-Encoding: binary");
        header('Content-Disposition: attachment; filename="' . $namafile . '"');
        header("Pragma: no-cache");
        header("Expires: 0");

        $queries = Yii::$app->db->createCommand("SELECT * FROM transaksi")->queryAll();
        foreach ($queries as $query) {
            echo $query['buku_id'] . ',' . 
            '"' . $query['santri_id'] . '",' . 
            '"' . $query['tanggal_peminjaman'] . '",' . 
            '"' . $query['tanggal_pengembalian'] . '"';
            echo "\n";
        }
        die();
    }

    public function actionBukuTruncate()
    {
        $query = Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE buku; SET FOREIGN_KEY_CHECKS = 1;')
        ->execute();
        return $this->redirect(['pengaturan', 'buku' => 'ya']);
    }

    public function actionSantriTruncate()
    {
        $query = Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE santri; SET FOREIGN_KEY_CHECKS = 1;')
        ->execute();
        return $this->redirect(['pengaturan', 'santri' => 'ya']);
    }

    public function actionBukutamuTruncate()
    {
        $query = Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE buku_tamu; SET FOREIGN_KEY_CHECKS = 1;')
        ->execute();
        return $this->redirect(['pengaturan', 'bukutamu' => 'ya']);
    }

    public function actionTransaksiTruncate()
    {
        $query = Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE transaksi; SET FOREIGN_KEY_CHECKS = 1;')
        ->execute();
        return $this->redirect(['pengaturan', 'transaksi' => 'ya']);
    }

    public function actionRestore() {
        $mode = $_POST['mode'];
        $csv = file_get_contents($_FILES['csv']['tmp_name']);
        $lines = explode(PHP_EOL, $csv);
        if ($mode == 'buku') {
            foreach ($lines as $line) {
                $part = str_getcsv($line, ',');
                if (isset($part[1])) {
                    $buku = new Buku();
                    if (is_numeric(trim($part[1]))) {
                        $buku->isbn = trim($part[1]);
                    } else {
                        $buku->isbn = 0;
                    }
                    $buku->pengarang = trim(str_replace('"', '', $part[2]));
                    $buku->judul = trim(str_replace('"', '', $part[0]));
                    $buku->penerbit = trim(str_replace('"', '', $part[3]));
                    $buku->stok = trim(str_replace('"', '', $part[5]));
                    $buku->kategori = trim(str_replace('"', '', $part[4]));
                    $buku->save();
                    if ($buku->isbn == 0) {
                        $buku->isbn = $buku->id;
                        $buku->save();
                    }
                }
            }
        }
        if ($mode == 'santri') {
            foreach ($lines as $line) {
                $part = str_getcsv($line, ',');
                if (isset($part[1])) {
                    $santri = new Santri();
                    $santri->nis = trim(str_replace('"', '', $part[0]));
                    $santri->nama = trim(str_replace('"', '', $part[1]));

                    $santri->save();
                }
            }
        }

        if ($mode == 'bukutamu') {
            foreach ($lines as $line) {
                $part = str_getcsv($line, ',');
                if (isset($part[1])) {
                    $bukutamu = new BukuTamu();
                    $bukutamu->santri_id = trim(str_replace('"', '', $part[0]));
                    $bukutamu->tanggal = trim(str_replace('"', '', $part[1]));

                    $bukutamu->save();
                }
            }
        }

         if ($mode == 'transaksi') {
            foreach ($lines as $line) {
                $part = str_getcsv($line, ',');
                if (isset($part[1])) {
                    $transaksi = new Transaksi();
                    $transaksi->buku_id = trim(str_replace('"', '', $part[0]));
                    $transaksi->santri_id = trim(str_replace('"', '', $part[1]));
                    $transaksi->tanggal_peminjaman = trim(str_replace('"', '', $part[2]));
                    $transaksi->tanggal_pengembalian = trim(str_replace('"', '', $part[3]));

                    $transaksi->save();
                }
            }
        }
        return $this->redirect(['pengaturan', 'csv' => 'ya', 'mode' => $mode]);
    }

    public function actionPengaturanDenda()
    {
        $maksimal_hari = $_POST['maksimal_hari'];
        $denda_per_hari = $_POST['denda_per_hari'];
        $model = Pengaturan::findOne(1);
        $model->maksimal_hari = $maksimal_hari;
        $model->denda_per_hari = $denda_per_hari;
        $model->save();

        return $this->redirect(['pengaturan', 'denda' => 'ya']);
    }

    public function actionMasuk() {
        $this->layout = 'main2';
        return $this->render('masuk');

    }

    public function actionMasukProses() {
        $password = file_get_contents(Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'KATA_SANDI.txt');
        if ($_POST['password'] == $password) {
            $_SESSION['admin'] = true;
            return $this->redirect(['index']);
        } else {
            $url = Url::to('masuk') . '?root=ya&proses=gagal';
            return $this->redirect($url);
        }
        
    }

    public function actionKeluar() {
        unset($_SESSION['admin']);
        return $this->redirect(['index']);
    }

}
