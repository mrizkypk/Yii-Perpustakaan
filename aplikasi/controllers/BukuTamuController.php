<?php

namespace app\controllers;

use Yii;
use app\models\Santri;
use app\models\BukuTamu;
use app\models\BukuTamuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BukuTamuController implements the CRUD actions for BukuTamu model.
 */
class BukuTamuController extends CController
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
     * Lists all BukuTamu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BukuTamuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new BukuTamu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($nis)
    {
        $santri = Santri::find()
        ->where(['nis' => $nis]) //Ini cuma test
        ->one();

        if (is_object($santri)) {
            $bukutamu = new BukuTamu();
            $bukutamu->santri_id = $santri->id;
            $bukutamu->tanggal = time();
            $bukutamu->save();
            
            return $this->redirect(['index', 'sort' => '-tanggal', 'notifikasi' => 'ya']);
        } else {
            return $this->redirect(['index', 'sort' => '-tanggal', 'notifikasi' => 'gagal']);
        }

    }

    /**
     * Updates an existing BukuTamu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'sort' => '-tanggal', 'notifikasi' => 'ya']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BukuTamu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BukuTamu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BukuTamu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BukuTamu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
