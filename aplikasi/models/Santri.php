<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "santri".
 *
 * @property integer $id
 * @property string $nis
 * @property string $nama
 *
 * @property Transaksi[] $transaksis
 */
class Santri extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'santri';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nis', 'nama'], 'required'],
            [['nis'], 'unique'],
            [['nis'], 'string', 'max' => 50],
            [['nama'], 'string', 'max' => 160],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nis' => 'Nis',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::className(), ['santri_id' => 'id']);
    }
}
