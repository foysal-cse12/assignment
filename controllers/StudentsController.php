<?php

namespace app\controllers;

use Yii;
use app\models\Students;
use app\models\Users;
use app\models\StudentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\filters\AccessControl;

/**
 * StudentsController implements the CRUD actions for Students model.
 */
class StudentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access'=>[

                   'class'=>AccessControl::className(),
                   //'only'=>['create','update','delete','read'],
                   'only'=>['*'],

                   'rules'=>[
                     [
                       'allow' => true,
                       'roles' => ['@'],
                     ],

                     [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['?'],
                      ],
                   ]

                ],



            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Students models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Students model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Students model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Students();
        $model_users = new Users();

        if ($model->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {

            $model->attributes = $_POST['Students'];
            $model_users->attributes = $_POST['Users'];
            $model_users->password = Yii::$app->security->generatePasswordHash($model_users->password);
            $model_users->user_type = 'student';

            $model_users->save();
            if($model_users->save())
            {
                $model->userid = $model_users->id;
                $model->save();
                //return $this->redirect(['/students/index']);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else
            {
               return $this->render('create', [
                'model' => $model,
                'model_users'=>$model_users,
               ]);
            }

            //$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'model_users'=>$model_users,
            ]);
        }
    }

    /**
     * Updates an existing Students model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Students model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $studentInfo = $this->findUserid($id);
        $userid = $studentInfo['userid'];
        //return 'userid: '.$userid;
        $this->findUserModel($userid)->delete();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Students model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Students the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Students::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserid($id)
    {
        if ( ($model = Students::findOne(['id'=>$id]) ) ){
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel($userid)
    {
        if (($model = Users::findOne(['id'=>$userid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }

    public function actionStudent_view($userid)
    {
            
            $studentInfo = Students::findOne(['userid'=>$userid]);
           // print_r($studentInfo);
            return $this->render('student_View', [
                'model'=>$studentInfo,
            ]);

        
    }

}
