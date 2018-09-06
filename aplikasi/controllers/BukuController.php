<?php

namespace app\controllers;

use Yii;
use app\models\Buku;
use app\models\BukuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BukuController implements the CRUD actions for Buku model.
 */
class BukuController extends CController
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
     * Lists all Buku models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BukuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBarcode($id) {
        $buku = Buku::findOne($id);        
        $isbn = $buku->isbn;
        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'barcode' . DIRECTORY_SEPARATOR . 'buku' . DIRECTORY_SEPARATOR . 'barcode_buku_' . $isbn . '.png';
        $generator = new \app\libraries\BarcodeGeneratorPNG();
        $png = $generator->getBarcode($isbn, $generator::TYPE_CODE_128);

        file_put_contents($path, $png);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($path);
        die();
    }

    public function actionSemuaBarcode() {
        $bukus = Buku::find()->all();
        foreach ($bukus as $buku) {
            $isbn = $buku->isbn;
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'barcode' . DIRECTORY_SEPARATOR . 'buku' . DIRECTORY_SEPARATOR . 'barcode_buku_' . $isbn . '.png';
            $generator = new \app\libraries\BarcodeGeneratorPNG();
            $png = $generator->getBarcode($isbn, $generator::TYPE_CODE_128);

            file_put_contents($path, $png);
        }

        return $this->redirect(['index', 'barcode' => 'ya']);
    }

    /**
     * Creates a new Buku model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Buku();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'sort' => '-id', 'notifikasi' => 'ya']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Buku model.
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
     * Deletes an existing Buku model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

/*
    public function actionTambahCsv() {
        $csv = file_get_contents($_FILES['csv']['tmp_name']);
        $lines = explode(PHP_EOL, $csv);
        foreach ($lines as $line) {
            $part = str_getcsv($line, ',');
            if (isset($part[1])) {
                $buku = new Buku();
                if (is_numeric(trim($part[0]))) {
                    $buku->isbn = trim($part[0]);
                } else {
                    $buku->isbn = 0;
                }
                $buku->pengarang = trim(str_replace('"', '', $part[1]));
                $buku->judul = trim(str_replace('"', '', $part[2]));
                $buku->penerbit = trim(str_replace('"', '', $part[3]));
                $buku->stok = trim($part[4]);
                $buku->kategori = trim($part[5]);
                $buku->save();
                if ($buku->isbn == 0) {
                    $buku->isbn = $buku->id;
                    $buku->save();
                }
            }
        }
        return $this->redirect(['index', 'csv' => 'ya']);
    }
*/


    public function actionTambahCsv() {
        $csv = file_get_contents($_FILES['csv']['tmp_name']);
        $lines = explode(PHP_EOL, $csv);
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
        return $this->redirect(['index', 'csv' => 'ya']);
    }

    /**
     * Finds the Buku model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Buku the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Buku::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
