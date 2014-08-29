app.config(function ($locationProvider, $stateProvider, $urlRouterProvider, $routeProvider) {
    $urlRouterProvider.otherwise('/user');

    // HOME STATES AND NESTED VIEWS ========================================
    $stateProvider.state('users', {
        url: '/user',
        templateUrl: 'views/user/index.html',
        controller: function ($scope, $API, $stateParams) {
            $scope.items_per_page = 5;
            $scope.currentPage = 1;
            $scope.sortField = "id";
            $scope.reverse = true;
            $scope.selection = [];
	    
	    $scope.hideDatefilter = true;
	    
	    $scope.pageSizeOptions=[5,10,30,50,100,200,500,1000];
	    
            $API.index("user", $scope, $scope.userFilter);
        }
    })

        // nested list with custom controller
        .state('users.create', {
            url: '/create',
            templateUrl: 'views/user/create.html',
            controller: function ($scope, $API, $stateParams) {
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
                $("#user_name").focus();
            }
        })

        .state('users.view', {
            url: '/:id',
            templateUrl: 'views/user/view.html',
            controller: function ($scope, $API, $stateParams) {
                $API.view("user", $stateParams.id, $scope);
            }
        })

        .state('users.update', {
            url: '/update/:id',
            templateUrl: 'views/user/update.html',
            controller: function ($scope, $API, $stateParams) {
                $scope.findbyId($stateParams.id);
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
            }
        })

        .state('cities', {
            url: '/city',
            templateUrl: 'views/city/index.html',
            controller: function ($scope, $API, $stateParams) {
                $scope.items_per_page = 5;
                $scope.currentPage = 1;
                $scope.sortField = "name";
                $scope.reverse = true;
                $scope.selection = [];
                $API.index("city", $scope, $scope.userFilter);
            }
        })

        .state('cities.create', {
            url: '/create',
            templateUrl: 'views/city/create.html',
            controller: function ($scope, $API, $stateParams) {
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
            }
        })

        .state('cities.view', {
            url: '/:id',
            templateUrl: 'views/city/view.html',
            controller: function ($scope, $API, $stateParams) {
                $API.view("city", $stateParams.id, $scope);
            }
        })

        .state('cities.update', {
            url: '/update/:id',
            templateUrl: 'views/city/update.html',
            controller: function ($scope, $API, $stateParams) {
                $scope.findbyId($stateParams.id);
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
            }
        })

	
    // ABOUT PAGE AND MULTIPLE NAMED VIEWS =================================
    /*
     .state('cities', {
     url: '/cities',
     templateUrl: 'views/city/index.html',

     // we'll get to this in a bit
     });
     */
});