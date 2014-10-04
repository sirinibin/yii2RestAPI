app.factory('$API', function ($http, $location) {

     //var host = "http://localhost:1337/";
    //var host = "http://angularsailscrud.herokuapp.com/";
   // var host = "index.php/api/";
    var host= "/yii2basic1/web/index.php/";
   //  var host= "api/";
    return {
        create: function (model, data, $scope) {
            var url = host + model + "/create";
            $http({
                method: 'POST',
                url: url,
                params: data,
                isArray: true
            })
                .success(function (data, status, headers, config) {
                    // alert("ok:"+angular.toJson(data));
                    $scope.models.push(data.data);
                    $scope.model = data.data;
                    $scope.showMessage("Succesfully Added!", 'success', true);
                    $scope.index();
                    $location.path(model + "/" + $scope.model.id);
                })
                .error(function (data, status, headers, config) {
		  // alert("ok:"+angular.toJson(data));
		      $scope.showMessage(angular.toJson(data), 'warning', true);
                  // $scope.showMessage("Sorry!Something went wrong", 'warning', true);
                   //  alert("ERR"+data);
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        },

        update: function (model, data, $scope) {
            var url = host + model + "/update/" + data.id;
            $http({
                method: 'POST',
                url: url,
                params: data,
                isArray: true
            })
                .success(function (data, status, headers, config) {
                    // alert("ok:"+angular.toJson(data));
                    // $scope.users.push(data);
                    $scope.model = data.data;
		     $scope.index();
                    $scope.showMessage("Succesfully Added!", 'success', true);
                    $location.path(model + "/" + $scope.model.id);
                })
                .error(function (data, status, headers, config) {
                    $scope.showMessage("Sorry!Something went wrong", 'warning', true);
                    // alert("ERR"+data);
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        },

        view: function (model, id, $scope) {
            var url = host + model + "/" + id;
            //alert("URL:"+url);
            $http({
                method: 'GET',
                url: url
            })
                .success(function (data, status, headers, config) {
                   // alert(angular.toJson(data));
                    // $scope.users.push(data);
                    $scope.model = data.data;
                    if ($scope.model) {
                        $('#view_container').modal({
                            show: true,
                            backdrop: false
                        });
                    }
                })
                .error(function (data, status, headers, config) {
                    $scope.showMessage("Sorry!Something went wrong", 'warning', true);
                    // alert("ERR");
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });

        },
       index: function (model, $scope) {
           
	 
	     
	  
	     
	   for (var field in $scope.dateFilter) {
	     
	       if($scope.dateFilter['from'])
	      {
		 $scope.dateFilter['from'].setHours(00,00,00,00);
	      }
	     if( $scope.dateFilter['to'])
	      {
		 $scope.dateFilter['to'].setHours(23,59,59,999);
	      }
		
		
	   }
	  
	
	      
            var url = host + model + "/index";
	    
            var data = {
                 page: $scope.currentPage,
                limit: $scope.items_per_page,
                 sort: $scope.sortField,
                order: $scope.reverse,
	       filter:$scope.filter,
	   datefilter:$scope.dateFilter
            };
	 //   alert(angular.toJson($scope.filter));
	      //alert(data);
	    // alert(angular.toJson(data));
	     
            $http({
                method: 'GET',
                url: url,
                params: data
            })
                .success(function (data, status, headers, config) {
                    
		       //alert(data);
		       //return;
		    // alert(angular.toJson(data));
		     
		      if(data.status==1)
		      {
			 $scope.models = data.data;
                         $scope.totalItems = data.totalItems;
			
		      }
		      else
		      {
                          $scope.showMessage("Sorry!Something went wrong" + data, 'warning', true);
		      }
		     
                    
                  
                })
                .error(function (data, status, headers, config) {
                  // alert("Err"+angular.toJson(data));
		     $scope.errors=data;
                });
        },
        delete: function (model, id, $scope) {
            var url = host + model + "/delete/" + id;
            $http({
                method: 'DELETE',
                url: url
            })
                .success(function (data, status, headers, config) {
                    $('#view_container').modal('hide');
                    $scope.showMessage("Deleted Succesfully!", 'success', true);
                    $scope.index();
                    // $scope.users.splice( $scope.users.indexOf(data), 1 );
                    //$location.path("/");
                    $location.path(model);
                })
                .error(function (data, status, headers, config) {
                    $scope.showMessage("Sorry!Something went wrong" + data, 'warning', true);
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        },
        deleteAll: function (model, $scope) {
	
            var url = host + model + "/deleteall/";
            var data = {
               // ids: $scope.selection
                ids: angular.toJson($scope.selection)
            };
              //alert(angular.toJson(data));
            $http({method: 'POST',
                url: url,
                params: data
            })
                .success(function (data, status, headers, config) {
                   //  alert(angular.toJson(data));
                     //return;
		    $('#view_container').modal('hide');
                    $scope.showMessage("Deleted Succesfully!", 'success', true);
                    $scope.index();
                    // $scope.users.splice( $scope.users.indexOf(data), 1 );
                    //$location.path("/");
                   // $location.path(model);

                })
                .error(function (data, status, headers, config) {
		    alert(angular.toJson(data));
                    $scope.showMessage("Sorry!Something went wrong:" + data, 'warning', true);
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
        }
    };
});