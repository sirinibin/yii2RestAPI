<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test1".
 *
 * @property integer $id
 * @property string $name
 */
class Test1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    public function beforeSave($insert)
    {
         if (parent::beforeSave($insert)) {
              if($this->isNewRecord)
               {
                 $this->createdAt=date("Y-m-d H:i:s",time());
                 $this->updatedAt=date("Y-m-d H:i:s",time());
               }
               else
               {
                 $this->updatedAt=date("Y-m-d H:i:s",time());
               }
               
              return true;
          } else {
              return false;
          }
    }
}
