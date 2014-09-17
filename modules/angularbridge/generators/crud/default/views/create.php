<?php

use yii\helpers\Inflector;
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelClass = StringHelper::basename($generator->modelClass);
$model = $generator->modelClass;

$pks = $model::primaryKey();
$pk=null;
foreach ($pks as $k) {
        $pk = $k;
        break;
    }
/*    
if (empty($safeAttributes)) {
    $safeAttributes = $model::attributes();
}
*/
?>

<div class="modal-header">
    <a ui-sref="<?= strtolower($modelClass) ?>" type="button" class="close" ng-click="closeModal();" aria-hidden="true">&times;</a>

    <h3 class="modal-title">Create New <?= strtolower($modelClass) ?></h3>
</div>

<div class="modal-body">
    <form role="form" name="<?= strtolower($modelClass) ?>form" id="<?= strtolower($modelClass) ?>form">
    
       <?php foreach ($generator->getColumnNames() as $attribute) {
		//if (in_array($attribute, $safeAttributes))
		if($pk!=$attribute)
		{
		  
		echo  '<div class="form-group" >
        
            <input type="text" ng-model="model.'.$attribute.'" id="model_'.$attribute.'"  placeholder="'.$attribute.'" class="form-control"
                   name="'.$attribute.'" >

        </div>';
		
		   // echo "    <?= " . $generator->generateActiveField($attribute) . " 
		}
      } ?>

        <div class="modal-footer">
            <button type="submit" value="SUBMIT" class="btn btn-primary" ng-click="create(model)"
                    ng-disabled="<?= strtolower($modelClass) ?>form.$invalid">SUBMIT
            </button>
        </div>
    </form>
   
   