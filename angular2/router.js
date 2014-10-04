app.config(function ($locationProvider, $stateProvider, $urlRouterProvider, $routeProvider) {
   
    /*============ TEST1 STATES AND NESTED VIEWS ================================================*/


   $urlRouterProvider.otherwise('/test1');

    $stateProvider.state('test1', {
        url: '/test1',
        templateUrl: 'views/test1/index.html',
        controller: function ($scope, $API, $stateParams) {
            $scope.items_per_page = 5;
            $scope.currentPage = 1;
            $scope.sortField = "id";
            $scope.reverse = false;
            $scope.selection = [];
	    
	    $scope.hideDatefilter = true;
	    
	    $scope.pageSizeOptions=[5,10,30,50,100,200,500,1000];
	    
            $API.index("test1", $scope, $scope.userFilter);
        }
    })

        // nested list with custom controller
        .state('test1.create', {
            url: '/create',
            templateUrl: 'views/test1/create.html',
            controller: function ($scope, $API, $stateParams) {
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
               
            }
        })

        .state('test1.view', {
            url: '/:id',
            templateUrl: 'views/test1/view.html',
            controller: function ($scope, $API, $stateParams) {
                $API.view("test1", $stateParams.id, $scope);
            }
        })

        .state('test1.update', {
            url: '/update/:id',
            templateUrl: 'views/test1/update.html',
            controller: function ($scope, $API, $stateParams) {
                $scope.findbyId($stateParams.id);
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
            }
        })
 }); 