<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengaturan".
 *
 * @property integer $id
 * @property integer $maksimal_hari
 * @property integer $denda_per_hari
 */
class Pengaturan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pengaturan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['maksimal_hari', 'denda_per_hari'], 'required'],
            [['maksimal_hari', 'denda_per_hari'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maksimal_hari' => 'Maksimal Hari',
            'denda_per_hari' => 'Denda Per Hari',
        ];
    }
}
