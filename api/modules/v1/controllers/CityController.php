<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
* Country Controller API
*
* @author Budi Irawan <deerawan@gmail.com>
*/
class CityController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\City';
}