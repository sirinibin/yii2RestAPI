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

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
<?php if (!empty($generator->searchModelClass)): ?>
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
<?php else: ?>
use yii\data\ActiveDataProvider;
<?php endif; ?>
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
   public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                     'index'=>['get'],
                     'view'=>['get'],
                     'create'=>['post'],
                     'update'=>['post'],
                     'delete' => ['delete'],
                     'deleteall'=>['delete'],
                ],
              
            ]
        ];
    }
    
   
    public function beforeAction($event)
    {
         $action = $event->id;
        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } else {
            return $event->isValid;
        }
         $verb = Yii::$app->getRequest()->getMethod();
       
       $allowed = array_map('strtoupper', $verbs);
       
       if (!in_array($verb, $allowed)) {
            
             $this->setHeader(400);
             echo json_encode(array('status'=>0,'error_code'=>400,'message'=>'Method not allowed'),JSON_PRETTY_PRINT);
             exit;
            
         }  
         
       return true;  
    } 

    /**
     * Lists all <?= $modelClass ?> models.
     * @return mixed
     */
    
     
    public function actionIndex()
    {
     
          $params=$_REQUEST;
          $filter=array();
          $sort="";
         
          $page=1;
          $limit=10;
             
           if(isset($params['page']))
             $page=$params['page'];
              
               
           if(isset($params['limit']))
              $limit=$params['limit'];
               
            $offset=$limit*($page-1);
             
             
            /* Filter elements */
           if(isset($params['filter']))
            {
             $filter=(array)json_decode($params['filter']);
            }
            
             if(isset($params['datefilter']))
            {
             $datefilter=(array)json_decode($params['datefilter']);
            }
            
             
            if(isset($params['sort']))
            {
              $sort=$params['sort'];
			  if(isset($params['order']))
			  {  
			      if($params['order']=="false")
			      $sort.=" desc";
			      else
			      $sort.=" asc";
			  
			  }
            }
         
                
               $query=new Query;
               $query->offset($offset)
	             ->limit($limit)
	             ->from('<?= $table ?>')
	             ->orderBy($sort);
	       <?= implode("\n        ", $searchConditions) ?>
	             
	       if($datefilter['from'])
	       {
	        $query->andWhere("createdAt >= '".$datefilter['from']."' ");
	       }
	       if($datefilter['to'])
	       {
	        $query->andWhere("createdAt <= '".$datefilter['to']."'");
	       }
	       $command = $query->createCommand();
               $models = $command->queryAll();
               
               $totalItems=$query->count();
          
          $this->setHeader(200);
         
          echo json_encode(array('status'=>1,'data'=>$models,'totalItems'=>$totalItems),JSON_PRETTY_PRINT);
       
    }

    /**
     * Displays a single <?= $modelClass ?> model.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionView(<?= $actionParams ?>)
    {
   
      $model=$this->findModel(<?= $actionParams ?>);
      
      $this->setHeader(200);
      echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
	
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
        $params=$_REQUEST;
         
        $model = new  <?= $modelClass ?>();
        $model->attributes=$params;
        
        

        if ($model->save()) {
        
             $this->setHeader(200);
             echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
          
        } 
        else
        {
             $this->setHeader(400);
             echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }
     
    }

    /**
     * Updates an existing <?= $modelClass ?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionUpdate(<?= $actionParams ?>)
    {
        $params=$_REQUEST;
    
        $model = $this->findModel(<?= $actionParams ?>);
    
        $model->attributes=$params;

        if ($model->save()) {
        
             $this->setHeader(200);
             echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
          
        } 
        else
        {
             $this->setHeader(400);
             echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }
        
    }

    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
        $model=$this->findModel(<?= $actionParams ?>);
        
        if($model->delete())
         { 
             $this->setHeader(200);
             echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
         
         }
         else
         {
           
             $this->setHeader(400);
             echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
         }

    }
    public function actionDeleteall()
    {
        $ids=json_decode($_REQUEST['ids']);
      
        $data=array();
        
        foreach($ids as $id)
        {
          $model=$this->findModel($id);
          
          if($model->delete())
            $data[]=array_filter($model->attributes);
          else
           {
             $this->setHeader(400);
             echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
             return;
           }  
        }
        
	$this->setHeader(200);
	echo json_encode(array('status'=>1,'data'=>$data),JSON_PRETTY_PRINT);

    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
       <?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
     if (($model = <?= $modelClass ?>::findOne(<?= $condition ?>)) !== null) {
            return $model;
        } else {
        
		  $this->setHeader(400);
		  echo json_encode(array('status'=>0,'error_code'=>400,'message'=>'Bad request'),JSON_PRETTY_PRINT);
		  exit;
         }
    }
    
    private function setHeader($status)
      {
	  
	  $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
	  $content_type="application/json; charset=utf-8";
	
	  header($status_header);
	  header('Content-type: ' . $content_type);
	  header('X-Powered-By: ' . "Nintriva <nintriva.com>");
      }
    private function _getStatusCodeMessage($status)
    {
	// these could be stored in a .ini file and loaded
	// via parse_ini_file()... however, this will suffice
	// for an example
	$codes = Array(
	    200 => 'OK',
	    400 => 'Bad Request',
	    401 => 'Unauthorized',
	    402 => 'Payment Required',
	    403 => 'Forbidden',
	    404 => 'Not Found',
	    500 => 'Internal Server Error',
	    501 => 'Not Implemented',
	);
	return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
