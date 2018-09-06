<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buku".
 *
 * @property integer $id
 * @property string $isbn
 * @property string $pengarang
 * @property string $judul
 * @property string $penerbit
 * @property integer $stok
 * @property string $kategori
 *
 * @property Transaksi[] $transaksis
 */
class Buku extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buku';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isbn', 'pengarang', 'judul', 'penerbit', 'stok', 'kategori'], 'required'],
            [['isbn'], 'unique'],
            [['pengarang', 'judul', 'penerbit', 'kategori'], 'string', 'max' => 160],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'isbn' => 'Isbn',
            'pengarang' => 'Pengarang',
            'judul' => 'Judul',
            'penerbit' => 'Penerbit',
            'stok' => 'Stok',
            'kategori' => 'Kategori',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::className(), ['buku_id' => 'id']);
    }

    public function sisa() {
        $model = Transaksi::find()
        ->where(['buku_id' => $this->id, 'tanggal_pengembalian' => null])
        ->all();
        $dipinjam = count($model);
        $sisa = $this->stok - $dipinjam;

        return ($sisa < 0 ? 0 : $sisa);
    }
}
