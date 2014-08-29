function UserCtrl($scope, $http, $API, $resource, $location, $log) {
    /*
     $scope.setPage = function (pageNo) {
     $scope.currentPage = pageNo;
     };
     */

    $scope.pageChanged = function () {
        // alert($scope.currentPage);
        // $scope.currentPage = 1;
        $API.index("user", $scope);
        //console.log('Page changed to: ' + $scope.currentPage);
    };

    $scope.create = function ($user) {
        $API.create("user", $user, $scope);
    };

    $scope.save = function ($user) {
        //alert("cool");
        $API.update("user", $user, $scope);
    };

    $scope.index = function () {
        $API.index("user", $scope);
    };

    $scope.closeModal = function () {
        $('#view_container').modal('toggle');
    };


    $scope.delete = function ($id) {
        var r = confirm("Are you sure?");
        if (r != true) {
            return;
        }
	  $API.delete("user",$id, $scope);
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
        $API.deleteAll("user", $scope);
    };

    $scope.findbyId = function (id) {
        for (var i = 0; i < $scope.models.length; i++) {
            if ($scope.models[i].id == id) {
                $scope.model = $scope.models[i];
                return;
                //return obj[i];
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
        $("#user_all").attr('checked', false);
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
    
     $scope.setDateRange = function(field) {
       
         if(field=="from")
		     {
		         
		        $scope.dateFilter[field].setHours(00,00,00,00);
		     
		        if ($scope.dateFilter['to'])
			{
			
			   $scope.dateFilter['to'].setHours(23,59,59,999);
			     
			   $scope.filter['createdAt'] = {'>=':$scope.dateFilter[field],'<=':$scope.dateFilter['to']}; 
			   
			}
			else
			{
			
		           $scope.filter['createdAt'] = {'>=':$scope.dateFilter[field]};
		
			}
		     }
		     else if(field=="to")
		     {
		  
		        $scope.dateFilter[field].setHours(23,59,59,999);
			
			
		        if ($scope.dateFilter['from'])
			{
			   $scope.dateFilter['from'].setHours(00,00,00,00);
			 
			   $scope.filter['createdAt'] = {'>=':$scope.dateFilter['from'],'<=':$scope.dateFilter[field]}; 
			}
			else
			{
		           $scope.filter['createdAt'] = {'<=':$scope.dateFilter[field]}
			}
		     }
       
    };
    
}