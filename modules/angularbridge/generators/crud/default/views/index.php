<?php

use yii\helpers\Inflector;
use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

$modelClass = StringHelper::basename($generator->modelClass);
$class = $generator->modelClass;

$pks = $class::primaryKey();
$pk=null;
foreach ($pks as $k) {
        $pk = $k;
        break;
    }
?>

<div ng-controller="<?= $modelClass ?>Ctrl">


    <br/><br/>

    <div row="row">


        <div class="col-md-9 col-md-offset-1">


            <h2><?= $modelClass ?></h2>


            <!--<a  class="btn btn-primary"  ng-click="open('','create.html');" ><i class="glyphicon glyphicon-plus"></i> Create</a>-->
            <!-- ng-click="renderCreateForm();" -->
            <!--<a  ng-href="#/create" class="btn btn-primary"   ><i class="glyphicon glyphicon-plus"></i> Create</a>-->

            <a ui-sref="<?= strtolower($modelClass) ?>.create" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Create</a>


            <!-- <button class="btn btn-default" ng-click="open('','modal1.html')">Create</button>-->

            <!--<script type="text/ng-template" id="modal1.html">-->


            <!--</script>-->
            <!-- Split button -->
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-primary">Actions</button>

                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu" role="menu">
                    <li><a href="" ng-click="deleteAll()">Delete</a></li>
                    <!--
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    -->
                </ul>
            </div>
            
            
            <button class="btn btn-default" ng-click="hideDatefilter = !hideDatefilter">Date filter</button>
				  
	      <div collapse="hideDatefilter">
	      <hr/>
		      <form id="date_filter">
		      From:<input type="text" class="input-sm" starting-day="1"  datepicker-popup="{{format}}" ng-model="dateFilter.from" is-open="from_opened" min-date="minDate" max-date="'2015-06-22'"  datepicker-options="dateOptions"  date-disabled="disabled(date, mode)"  close-text="Close" />
			  
			  <button type="button" class="btn btn-default" ng-click="openDatePicker($event,'from')"><i class="glyphicon glyphicon-calendar"></i></button>
			
			To:<input type="text"  class="input-sm" datepicker-popup="{{format}}" ng-model="dateFilter.to" is-open="to_opened" min-date="minDate" max-date="'2015-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)"  close-text="Close" />
			  
			  <button type="button" class="btn btn-default" ng-click="openDatePicker($event,'to')"><i class="glyphicon glyphicon-calendar"></i></button>

			<input type="button" class="btn btn-primary" value="GO" ng-click="index()" />
		    </form>  
	      </div>
      
      
            <hr/>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-condensed">
                    <th></th>
                    
                    <?php
		      $count = 0;
		      if (($tableSchema = $generator->getTableSchema()) === false) {
			  foreach ($generator->getColumnNames() as $name) {
			   echo'
			   <th>
                              <a href="" ng-click="sortField=\''.$name.'\';reverse=!reverse;index();">'.$name.'</a>
                           </th>';
			     /*
			      if (++$count < 6) {
				  echo "            '" . $name . "',\n";
			      } else {
				  echo "            // '" . $name . "',\n";
			      }
			      */
			  }
		      } else {
			  foreach ($tableSchema->columns as $column) {
			      $format = $generator->generateColumnFormat($column);
			     
			      echo'
			   <th>
                              <a href="" ng-click="sortField=\''.$column->name.'\';reverse=!reverse;index();">'.$column->name.'</a>
                           </th>';
                           
			     /*
			     if (++$count < 6) {
				  echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      } else {
				  echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      }
			      */
			  }
		      }
		       echo "\n";
		      ?>
                    <th colspan="3" class="col-md-3">Actions</th>
                    <tr>
                        <td><input id="<?= strtolower($modelClass) ?>_all" type="checkbox" value="" ng-click="selectAll($event)" /></td>
                        <form id="filter_form">
                            
                             <?php
		      $count = 0;
		      if (($tableSchema = $generator->getTableSchema()) === false) {
			  foreach ($generator->getColumnNames() as $name) {
			   echo'
			    <td><input type="text" size="4" ng-model="'.strtolower($modelClass).'Filter.'.$name.'" placeholder=""
                                       ng-keyup="index();"/></td>';
			     /*
			      if (++$count < 6) {
				  echo "            '" . $name . "',\n";
			      } else {
				  echo "            // '" . $name . "',\n";
			      }
			      */
			  }
		      } else {
			  foreach ($tableSchema->columns as $column) {
			      $format = $generator->generateColumnFormat($column);
			     
			      echo'
			    <td><input type="text" size="4" ng-model="'.strtolower($modelClass).'Filter.'.$column->name.'" placeholder=""
                                       ng-keyup="index();"/></td>';
                           
			     /*
			     if (++$count < 6) {
				  echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      } else {
				  echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      }
			      */
			  }
		      }
		      ?>
		      
                            <td></td>
                            <td></td>
                        </form>
                    </tr>
                    <!-- filter:{id:idFilter,name:nameFilter,age:ageFilter,active:activeFilter} -->
                    <!--https://docs.angularjs.org/error/ngRepeat/dupes?p0=user%20in%20users&p1=object:00B-->
                    <tr  ng-repeat="<?= strtolower($modelClass) ?> in models track by <?= strtolower($modelClass) ?>.<?= $pk ?>" ng-animate=" 'slide' ">
                        <td><input id="{{<?= strtolower($modelClass) ?>.<?= $pk ?>}}" type="checkbox" value="{{<?= strtolower($modelClass) ?>.<?= $pk ?>}}"
                                   ng-checked="selection.indexOf(<?= strtolower($modelClass) ?>.<?= $pk ?>) > -1" ng-click="toggleSelection(<?= strtolower($modelClass) ?>.<?= $pk ?>)"/>
                        </td>
                         <?php
		      $count = 0;
		      if (($tableSchema = $generator->getTableSchema()) === false) {
			  foreach ($generator->getColumnNames() as $name) {
			   echo'
			    <td>{{'.strtolower($modelClass).'.'.$name.'}}</td>';
			     /*
			      if (++$count < 6) {
				  echo "            '" . $name . "',\n";
			      } else {
				  echo "            // '" . $name . "',\n";
			      }
			      */
			  }
		      } else {
			  foreach ($tableSchema->columns as $column) {
			      $format = $generator->generateColumnFormat($column);
			     
			      echo'
			    <td>{{'.strtolower($modelClass).'.'.$column->name.'}}</td>';
                           
			     /*
			     if (++$count < 6) {
				  echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      } else {
				  echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
			      }
			      */
			  }
		      }
		      ?>
		      
                        <td><a ui-sref="<?= strtolower($modelClass) ?>.view({<?= $pk ?>:<?= strtolower($modelClass) ?>.<?= $pk ?>})"
                               class="btn btn-default glyphicon glyphicon-eye-open"></a>
                            <!--</td>
                            <td>-->
                            <a ui-sref="<?= strtolower($modelClass) ?>.update({<?= $pk ?>:<?= strtolower($modelClass) ?>.<?= $pk ?>})"
                               class="btn btn-primary glyphicon glyphicon-pencil"></a>
                            <!--
                            </td>
                            <td>
                            -->
                            <a href="" ng-click="delete(<?= strtolower($modelClass) ?>.<?= $pk ?>)" class="btn btn-danger glyphicon glyphicon-remove"></a>
                        </td>

                    </tr>
                </table>
              <div class="pull-right">  
              PageSize:<select class="form-control input-sm" ng-model="items_per_page" ng-change="pageChanged()" ng-options="size for size in pageSizeOptions" ></select>
              </div>
                <pagination total-items="totalItems" items-per-page="items_per_page" ng-model="currentPage"
                            ng-change="pageChanged()"></pagination>

            </div>

            <!--
            <div class="alert alert-success col-md-3 col-md-offset-12">
              <a href="#" class="alert-link"> Succesfully Added</a>
            </div>
          -->
        </div>
        <br/>

        <div class="col-md-3 " id="alert_container">


        </div>
        <!--
        <div class="alert alert-warning alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Warning!</strong> Better check yourself, you're not looking too good.
				    </div>
				    -->

    </div>
   
       
    <div id="view_container" class="modal">


        <div class="modal-dialog">

            <div class="modal-content">


                <div ui-view>View here</div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    
</div>
		     
		     
			      
			     
		             
			      
			      
			      
		    