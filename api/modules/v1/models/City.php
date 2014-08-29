<?php

namespace api\modules\v1\models;

use \yii\db\ActiveRecord;

/**
* City Model
*
* @author Budi Irawan <deerawan@gmail.com>
*/
class City extends ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'city';
}	
}