<?php

namespace app\controllers;

use Yii;
use app\libraries\BarcodeGenerator;
use yii\helpers\Url;
use app\models\Santri;
use app\models\SantriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * SantriController implements the CRUD actions for Santri model.
 */
class SantriController extends CController
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
     * Lists all Santri models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SantriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Santri model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Santri();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'sort' => '-id', 'notifikasi' => 'ya']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Santri model.
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
     * Deletes an existing Santri model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionKartu($id) {
        $santri = Santri::findOne($id);        
        $nis = $santri->nis;
        $nama = preg_replace('/[^A-Za-z\s]/', '', strtolower($santri->nama));
        $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'barcode' . DIRECTORY_SEPARATOR . 'santri' . DIRECTORY_SEPARATOR . 'barcode_santri_' . $nis . '.png';
        $generator = new \app\libraries\BarcodeGeneratorPNG();
        $png = $generator->getBarcode($nis, $generator::TYPE_CODE_128);

        file_put_contents($path, $png);
        $queries = [
            'nama' => $santri->nama,
            'nis' => $santri->nis
        ];

        return $this->redirect(Url::home(true) . 'kartu.php?' . http_build_query($queries));
    }

    public function actionSemuaKartu() {
        $santris = Santri::find()->all();
        foreach ($santris as $santri) {
            $nis = $santri->nis;
            $nama = preg_replace('/[^A-Za-z\s]/', '', strtolower($santri->nama));
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'barcode' . DIRECTORY_SEPARATOR . 'santri' . DIRECTORY_SEPARATOR . 'barcode_santri_' . $nis . '.png';
            $generator = new \app\libraries\BarcodeGeneratorPNG();
            $png = $generator->getBarcode($nis, $generator::TYPE_CODE_128);

            file_put_contents($path, $png);
            $queries = [
                'nama' => $santri->nama,
                'nis' => $santri->nis
            ];
            $done = file_get_contents(Url::home(true) . 'semua-kartu.php?' . http_build_query($queries));
        }

        return $this->redirect(['index', 'kartu' => 'ya']);
    }


    public function actionRiwayat($id) {
        $santri = Santri::findOne($id);        
        $nis = $santri->nis;
        $nama = preg_replace('/[^A-Za-z\s]/', '', strtolower($santri->nama));
        $queries = [
            'nama' => $santri->nama,
            'nis' => $santri->nis
        ];        

        return $this->redirect(Url::home(true) . 'riwayat.php?' . http_build_query($queries));
    }

    public function actionSemuaRiwayat() {
        $santris = Santri::find()->all();
        foreach ($santris as $santri) {
            $nis = $santri->nis;
            $nama = preg_replace('/[^A-Za-z\s]/', '', strtolower($santri->nama));
            $queries = [
                'nama' => $santri->nama,
                'nis' => $santri->nis
            ];
            $done = file_get_contents(Url::home(true) . 'semua-riwayat.php?' . http_build_query($queries));
        }

        return $this->redirect(['index', 'riwayat' => 'ya']);
    }


    public function actionTambahCsv() {
        $csv = file_get_contents($_FILES['csv']['tmp_name']);
        $lines = explode(PHP_EOL, $csv);
        foreach ($lines as $line) {
            $part = str_getcsv($line, ',');
            if (isset($part[1])) {
                $santri = new Santri();
                $santri->nis = trim(str_replace('"', '', $part[0]));
                $santri->nama = trim(str_replace('"', '', $part[1]));

                $santri->save();
            }
        }
        return $this->redirect(['index', 'csv' => 'ya']);
    }

    /**
     * Finds the Santri model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Santri the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Santri::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
