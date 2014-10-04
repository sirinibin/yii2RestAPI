
function Test1Ctrl($scope, $http, $API, $resource, $location, $log) {

    $scope.pageChanged = function () {
    
         $API.index("test1", $scope); 
    };

    $scope.create = function ($test1) {
        $API.create("test1", $test1, $scope);
    };

    $scope.save = function ($test1) {
        //alert("cool");
        $API.update("test1", $test1, $scope);
    };

    $scope.index = function () {
         $scope.filter={};
	   
           for (var field in $scope.test1Filter) {
	          
                
	        if ($scope.test1Filter[field]) {
		  
                      
		      $scope.filter[field] = $scope.test1Filter[field];
		     
                }
            }
            
        $API.index("test1", $scope);
    };

    $scope.closeModal = function () {
        $('#view_container').modal('toggle');
    };


    $scope.delete = function ($id) {
        var r = confirm("Are you sure?");
        if (r != true) {
            return;
        }
	  $API.delete("test1",$id, $scope);
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
        $API.deleteAll("test1", $scope);
    };

    $scope.findbyId = function (id) {
        for (var i = 0; i < $scope.models.length; i++) {
            if ($scope.models[i].id == id) {
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
        $("#test1_all").attr('checked', false);
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
            var idx = $scope.selection.indexOf($scope.models[i].id);
            if (idx > -1) {
                if (!checkbox.checked) {
                    $scope.selection.splice(idx, 1);
                }
            }
            // is newly selected
            else {
                $scope.selection.push($scope.models[i].id);
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