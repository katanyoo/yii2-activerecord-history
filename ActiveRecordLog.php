<?php

namespace katanyoo\activerecordhistory;

use Yii;

/**
 * This is the model class for table "activerecord_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $description
 * @property string $action
 * @property string $model
 * @property integer $model_id
 * @property string $field
 * @property string $old_value
 * @property string $new_value
 * @property integer $created_at
 * @property integer $updated_at
 */
class ActiveRecordLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activerecord_log';
    }


    public static function getDb() {
        return Yii::$app->db2;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'model_id', 'created_at'], 'integer'],
            [['description', 'old_value', 'new_value'], 'string'],
            [['created_at'], 'required'],
            [['action'], 'string', 'max' => 20],
            [['model', 'field'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'description' => 'Description',
            'action' => 'Action',
            'model' => 'Model',
            'model_id' => 'Model ID',
            'field' => 'Field',
            'old_value' => 'Old Value',
            'new_value' => 'New Value',
            'created_at' => 'Created At',
        ];
    }
}
