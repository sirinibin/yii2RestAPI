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

    <h3 class="modal-title">Update #{{model.id}}</h3>
    <a ng-href="#/<?= strtolower($modelClass) ?>/create" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Create</a>
</div>

<div class="modal-body">

    <div class="pull-right">
        <a ui-sref="<?= strtolower($modelClass) ?>.view({<?= $pk ?>:model.<?= $pk ?>})" class="btn btn-primary glyphicon glyphicon-eye-open"></a>
        <a href="" ng-click="delete(model.<?= $pk ?>)" class="btn btn-danger glyphicon glyphicon-remove"></a>
    </div>

    <form role="form">
        <input type="hidden" ng-model="model.<?= $pk ?>">
         
        <?php foreach ($generator->getColumnNames() as $attribute) {
		//if (in_array($attribute, $safeAttributes))
		if($pk!=$attribute)
		{
		?>  
		 <div class="form-group">
            <label for="model.<?= $attribute ?>"><?= $attribute ?>:</label>
            <input type="text" ng-model="model.<?= $attribute ?>" size="30" placeholder="<?= $attribute ?>" value="{{model.<?= $attribute ?>}}"
                   class="form-control">
        </div>
		
		<?php
		   // echo "    <?= " . $generator->generateActiveField($attribute) . " 
		}
      } ?>



        <div class="modal-footer">
            <button type="submit" value="SUBMIT" class="btn btn-primary" ng-click="save(model)">SUBMIT</button>

        </div>

    </form>

</div>