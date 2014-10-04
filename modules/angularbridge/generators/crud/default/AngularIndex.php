<!DOCTYPE html>
<html ng-app="app">
<head>
    <title>Angular Sails CRUD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <script src="js/angular.min.js"></script>
    <script src="js/angular-route.min.js"></script>
    <script src="js/angular-ui-router.min.js"></script>
    <script src="js/angular-resource.min.js"></script>
    <script src="js/angular-animate.min.js"></script>
    <script src="js/ui-bootstrap-tpls-0.11.0.min.js"></script>

    <link href="bootstrap3/css/bootstrap.min.css" rel="stylesheet">

    <script src="bootstrap3/js/jquery.min.js"></script>
    <script src="bootstrap3/js/bootstrap.min.js"></script>
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.10/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.10/angular-route.js"></script>
    -->
    <script src="todo.js"></script>
</head>
<body ng-app="app">
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">AngularJs + SailsJs + Bootstrap3 CRUD</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a ui-sref="users">Users</a></li>
                <li><a ui-sref="cities">Cities</a></li>
              
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
<div ui-view>
</div>
</body>
<script>
    var app = angular.module('app', ['ngRoute', 'ui.bootstrap', 'ngAnimate', 'ngResource', 'ui.router']);
</script>
<script src="router.js"></script>
<script src="API/API.js"></script>
</html>
<script src="controllers/Test1Controller.js"></script>