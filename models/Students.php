<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "students".
 *
 * @property string $id
 * @property string $userid
 * @property string $full_name
 * @property string $father_name
 * @property string $mother_name
 * @property string $address
 * @property string $contact_number
 * @property string $class
 * @property integer $age
 * @property double $iq_score
 * @property string $social_status
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'full_name', 'father_name', 'mother_name', 'address', 'contact_number', 'class', 'age', 'iq_score'], 'required'],//'social_status'
            ['full_name', 'filter', 'filter' => 'trim'],
            ['father_name', 'filter', 'filter' => 'trim'],
            ['mother_name', 'filter', 'filter' => 'trim'],
            ['address', 'filter', 'filter' => 'trim'],
            ['contact_number', 'filter', 'filter' => 'trim'],
            [['address'], 'string'],
            [['age'], 'integer'],
            [['iq_score'], 'number'],
            [['userid'], 'string', 'max' => 255],
            [['full_name', 'father_name', 'mother_name', 'class', 'social_status'], 'string', 'max' => 50],
            [['contact_number'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'full_name' => 'Full Name',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'address' => 'Address',
            'contact_number' => 'Contact Number',
            'class' => 'Class',
            'age' => 'Age',
            'iq_score' => 'IQ Score',
            'social_status' => 'Social Status',
        ];
    }
}
