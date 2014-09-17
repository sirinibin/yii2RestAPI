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
    <a ui-sref="<?= strtolower($modelClass) ?>" type="button" ng-click="closeModal()" class="close" aria-hidden="true">&times;</a>

    <h3 class="modal-title">View #{{model.<?= $pk; ?>}}</h3>

    <a ui-sref="<?= strtolower($modelClass) ?>.create" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Create</a>


</div>


<div class="modal-body">


    <div class="pull-right">

        <a ui-sref="<?= strtolower($modelClass) ?>.update({<?= $pk ?>:model.<?= $pk ?>})" class="btn btn-primary glyphicon glyphicon-pencil"></a>
        <a href="" ng-click="delete(model.<?= $pk ?>)" class="btn btn-danger glyphicon glyphicon-remove"></a>
    </div>


    <ul>
        <?php foreach ($generator->getColumnNames() as $attribute) {
		//if (in_array($attribute, $safeAttributes))
		if($pk!=$attribute)
		{
		?>  
		 <li><?= $attribute ?>:{{model.<?= $attribute ?>}}</li>
		<?php 
		}
      } ?>
    </ul>

</div>