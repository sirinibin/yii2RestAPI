 <?php
/**
 * This is the template for generating a CRUD controller class file.
 */

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$table= $class::tableName();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();
$searchConditions = $generator->generateSearchConditions();

?>
 $urlRouterProvider.otherwise('/<?= strtolower($modelClass) ?>');

    $stateProvider.state('<?= strtolower($modelClass) ?>', {
        url: '/<?= strtolower($modelClass) ?>',
        templateUrl: 'views/<?= strtolower($modelClass) ?>/index.html',
        controller: function ($scope, $API, $stateParams) {
            $scope.items_per_page = 5;
            $scope.currentPage = 1;
            $scope.sortField = "id";
            $scope.reverse = false;
            $scope.selection = [];
	    
	    $scope.hideDatefilter = true;
	    
	    $scope.pageSizeOptions=[5,10,30,50,100,200,500,1000];
	    
            $API.index("<?= strtolower($modelClass) ?>", $scope, $scope.userFilter);
        }
    })

        // nested list with custom controller
        .state('<?= strtolower($modelClass) ?>.create', {
            url: '/create',
            templateUrl: 'views/<?= strtolower($modelClass) ?>/create.html',
            controller: function ($scope, $API, $stateParams) {
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
               
            }
        })

        .state('<?= strtolower($modelClass) ?>.view', {
            url: '/:id',
            templateUrl: 'views/<?= strtolower($modelClass) ?>/view.html',
            controller: function ($scope, $API, $stateParams) {
                $API.view("<?= strtolower($modelClass) ?>", $stateParams.id, $scope);
            }
        })

        .state('<?= strtolower($modelClass) ?>.update', {
            url: '/update/:id',
            templateUrl: 'views/<?= strtolower($modelClass) ?>/update.html',
            controller: function ($scope, $API, $stateParams) {
                $scope.findbyId($stateParams.id);
                $('#view_container').modal({
                    show: true,
                    backdrop: false
                });
            }
        })