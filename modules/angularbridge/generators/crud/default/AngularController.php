<?php

use yii\helpers\Inflector;
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */


$modelClass = StringHelper::basename($generator->modelClass);
$model = $generator->modelClass;

$pks = $model::primaryKey();
$pk=null;
foreach ($pks as $k) {
        $pk = $k;
        break;
    }
?>

function <?= $modelClass ?>Ctrl($scope, $http, $API, $resource, $location, $log) {

    $scope.pageChanged = function () {
    
         $API.index("<?= strtolower($modelClass) ?>", $scope); 
    };

    $scope.create = function ($<?= strtolower($modelClass) ?>) {
        $API.create("<?= strtolower($modelClass) ?>", $<?= strtolower($modelClass) ?>, $scope);
    };

    $scope.save = function ($<?= strtolower($modelClass) ?>) {
        //alert("cool");
        $API.update("<?= strtolower($modelClass) ?>", $<?= strtolower($modelClass) ?>, $scope);
    };

    $scope.index = function () {
         $scope.filter={};
	   
           for (var field in $scope.<?= strtolower($modelClass) ?>1Filter) {
	            // alert(field);
                
	        if ($scope.<?= strtolower($modelClass) ?>Filter[field]) {
		  
                      
		      $scope.filter[field] = $scope.<?= strtolower($modelClass) ?>Filter[field];
		     
                }
            }
            
        $API.index("<?= strtolower($modelClass) ?>", $scope);
    };

    $scope.closeModal = function () {
        $('#view_container').modal('toggle');
    };


    $scope.delete = function ($<?= $pk ?>) {
        var r = confirm("Are you sure?");
        if (r != true) {
            return;
        }
	  $API.delete("<?= strtolower($modelClass) ?>",$<?= $pk ?>, $scope);
    };

    $scope.deleteAll = function ($model) {
        var r = confirm("Are you sure?");
        if (r != true) {
            return;
        }
        if ($scope.selection.length == 0) {
            alert("No records selected");
            return;
        }
        $API.deleteAll("<?= strtolower($modelClass) ?>", $scope);
    };

    $scope.findbyId = function (<?= $pk ?>) {
        for (var i = 0; i < $scope.models.length; i++) {
            if ($scope.models[i].<?= $pk ?> == <?= $pk ?>) {
                $scope.model = $scope.models[i];
                return;
            }
        }
    };

    $scope.hideMessage = function () {
        $("#alert_container").html("");
    };

    $scope.showMessage = function (message, type, fadeOut) {
        var content = '<div class="alert alert-' + type + ' alert-dismissable">\
		                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\
			                <a href="#" class="alert-link"> ' + message + '</a>\
		               </div>';
        $("#alert_container").append(content);
        if (fadeOut == true) {
            $(".alert").fadeOut(4000);
        }
    };

    // toggle selection for a given employee by name
    
    $scope.toggleSelection = function toggleSelection(id) {
        var idx = $scope.selection.indexOf(id);
        $("#<?= strtolower($modelClass) ?>_all").attr('checked', false);
        // is currently selected
        if (idx > -1) {
            $scope.selection.splice(idx, 1);
        }
        // is newly selected
        else {
            $scope.selection.push(id);
        }
    };

    $scope.selectAll = function ($event) {
        var checkbox = $event.target;
        for (var i in $scope.models) {
            var idx = $scope.selection.indexOf($scope.models[i].<?= $pk ?>);
            if (idx > -1) {
                if (!checkbox.checked) {
                    $scope.selection.splice(idx, 1);
                }
            }
            // is newly selected
            else {
                $scope.selection.push($scope.models[i].<?= $pk ?>);
            }
        }
    };
    
     $scope.openDatePicker = function($event,$name) {
         
		$event.preventDefault();
		$event.stopPropagation();
             
	      if($name=="from")
		$scope.from_opened = true;
	      else
		$scope.to_opened = true;
		
     };
    

    
}