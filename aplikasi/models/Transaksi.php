<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property integer $id
 * @property integer $buku_id
 * @property integer $santri_id
 * @property string $tanggal_peminjaman
 * @property string $tanggal_pengembalian
 *
 * @property Buku $buku
 * @property Santri $santri
 */
class Transaksi extends \yii\db\ActiveRecord
{

    public $santri_nama;
    public $buku_judul;
    public $buku_pengarang;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['buku_id', 'santri_id'], 'required'],
            [['buku_id', 'santri_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'buku_id' => 'Buku ID',
            'buku_judul' => 'Buku',
            'buku_pengarang' => 'Pengarang',
            'santri_id' => 'Santri ID',
            'santri_nama' => 'Santri',
            'tanggal_peminjaman' => 'Tanggal Peminjaman',
            'tanggal_pengembalian' => 'Tanggal Pengembalian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuku()
    {
        return $this->hasOne(Buku::className(), ['id' => 'buku_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSantri()
    {
        return $this->hasOne(Santri::className(), ['id' => 'santri_id']);
    }

    public function dateIndonesia($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB') {
        if (trim ($timestamp) == '') {
                $timestamp = time ();
        } elseif (!ctype_digit ($timestamp)) {
            $timestamp = strtotime ($timestamp);
        }
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date} {$suffix}";
        return $date;
    }

    public function getTanggalPeminjaman() {
        if ($this->tanggal_peminjaman == null) return '';
        return $this->dateIndonesia($this->tanggal_peminjaman, 'l, j F Y H:i:s');
    }


    public function getTanggalPeminjamanSingkat() {
        if ($this->tanggal_peminjaman == null) return '';
        return date('d/m/y', $this->tanggal_peminjaman);
    }

    public function getTanggalPengembalian() {
        if ($this->tanggal_pengembalian == null) return '';
        return $this->dateIndonesia($this->tanggal_pengembalian, 'l, j F Y H:i:s');
    }


    public function getTanggalPengembalianSingkat() {
        if ($this->tanggal_pengembalian == null) return '';
        return date('d/m/y', $this->tanggal_pengembalian);
    }

    public function getDenda() {
        if ($this->tanggal_pengembalian == null) {
            return '';
        } else {
            $pengaturan = Pengaturan::findOne(1);
            $days = (int) ( abs($this->tanggal_pengembalian - $this->tanggal_peminjaman) / ( 60 * 60 * 24 ) ) - $pengaturan->maksimal_hari;
            if ($days < 1) {
                return '';
            }
            return 'Rp. ' . number_format(($days * $pengaturan->denda_per_hari), 0, ',', '.');
        }
    }
}
