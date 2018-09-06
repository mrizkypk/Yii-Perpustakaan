<?php

namespace app\controllers;

use Yii;
use app\models\Buku;
use app\models\Santri;
use app\models\Transaksi;
use app\models\TransaksiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransaksiController implements the CRUD actions for Transaksi model.
 */
class TransaksiController extends CController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaksi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TransaksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Transaksi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaksi();
        $model->tanggal_peminjaman = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'sort' => '-id', 'notifikasi' => 'ya']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transaksi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'sort' => '-id', 'notifikasi' => 'ya']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Transaksi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionBuku($isbn) {
        $model = Buku::find()
        ->where(['isbn' => $isbn])
        ->one();

        $model2 = Transaksi::find()
        ->where(['buku_id' => $model->id, 'tanggal_pengembalian' => null])
        ->all();
        $dipinjam = count($model2);

        
        if (($model->stok - $dipinjam) < 1) {
            $array = [
                'id' => 0,
                'judul' => 'STOK BUKU HABIS',
            ];
        } else {
            if (is_object($model)) {
                $array = [
                    'id' => $model->id,
                    'judul' => $model->judul,
                ];
       
            } else {
                $array = [
                    'id' => 0,
                    'judul' => 'BUKU TIDAK TERDAFTAR',
                ];
            }
        }
        
        echo json_encode($array);
    }


    public function actionBuku2($isbn) {

        $model = Buku::find()
        ->where(['isbn' => $isbn])
        ->one();

        $model2 = Transaksi::find()
        ->where(['buku_id' => $model->id, 'tanggal_pengembalian' => null])
        ->all();
        $dipinjam = count($model2);


        if (is_object($model)) {
            $array = [
                'id' => $model->id,
                'judul' => $model->judul,
            ];
        } else {
            $array = [
                'id' => 0,
                'judul' => 'BUKU TIDAK TERDAFTAR',
            ];
        }
        
        echo json_encode($array);
    }


    public function actionSantri($nis) {
        $model = Santri::find()
        ->where(['nis' => $nis])
        ->one();
        
        if (is_object($model)) {
            $array = [
                'id' => $model->id,
                'nama' => $model->nama,
            ];
        } else {
            $array = [
                'id' => 0,
                'nama' => 'SANTRI TIDAK TERDAFTAR',
            ];
        }
        echo json_encode($array);
    }


    public function actionPengembalian($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_pengembalian = time();
        $model->save();

        return $this->redirect(['index', 'sort' => '-tanggal_pengembalian', 'notifikasi' => 'ya']);

    }

    public function actionPengembalian2()
    {
        $buku_id = $_POST['transaksi-buku_id2'];
        $santri_id = $_POST['transaksi-santri_id2'];

        $model = Transaksi::find()
        ->where(['buku_id' => $buku_id, 'santri_id' => $santri_id, 'tanggal_pengembalian' => null])
        ->one();

        $model->tanggal_pengembalian = time();
        $model->save();

        return $this->redirect(['index', 'sort' => '-tanggal_pengembalian', 'notifikasi' => 'ya']);

    }

    public function actionCetak() {
        if (isset($_GET['TransaksiSearch']['santri_id'])) {
            $id = $_GET['TransaksiSearch']['santri_id'];
            $model = Santri::findOne($id);
            $nis = $model->nis;
            $santri = $model->nama;
        } else {
            $nis = false;
            $santri = false;
        }

        $searchModel = new TransaksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 15];

        return $this->render('cetak', [
            'nis' => $nis,
            'santri' => $santri,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCetakKosong() {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=cetak.doc");
        $this->layout = 'main2';
        return $this->render('cetak-kosong');
    }

    /**
     * Finds the Transaksi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaksi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaksi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
