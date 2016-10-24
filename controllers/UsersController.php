<?php

namespace app\controllers;

use Yii;
use app\models\Users;
use app\models\Students;
use app\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\filters\AccessControl;
use app\models\StudentPasswordForm;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access'=>[

               'class'=>AccessControl::className(),
               'except'=>['create'],
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
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post())) {

            //$model->password = md5($model->password);
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->user_type = 'teacher';
            $model->save();
            return $this->redirect(['/site/login']);
            //return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['user_profile', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $studentInfo = $this->findUserid($id);
        $userid = $studentInfo['userid'];
        $this->findUserModel($userid)->delete();
        $this->findModel($id)->delete();

        return $this->redirect(['/students/index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUser_profile()
    {
        
        $session = Yii::$app->session;
        $session->open();
        $id = $session['userid'];
        $profile = Users::findOne(['id'=>$id]);
       // print_r($profile);
        return $this->render('user_profile',['model'=>$profile]);

    }

    public function actionStudent_account()
    {
       $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('students_account', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate_student_account($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update_student_account', [
                'model' => $model,
            ]);
        }
    }

    public function findUserid($id)
    {
        if ( ($model = Students::findOne(['userid'=>$id]) ) ){
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserModel($userid)
    {
        if (($model = Students::findOne(['userid'=>$userid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
    }

    public function actionChange_student_password($id)
    {
        
        $model = new StudentPasswordForm();
        $student = Users::find()->where([
            'id'=>$id
        ])->one();

        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate()){
                try{
                    $student->password = $_POST['StudentPasswordForm']['password'];
                    $student->password = Yii::$app->security->generatePasswordHash($student->password);
                    if($student->save())
                    {
                        Yii::$app->getSession()->setFlash(
                            'success','Password changed'
                        );
                        return $this->redirect(['view','id'=>$id]);
                      
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Password not changed'
                        );
                        return $this->redirect(['view','id'=>$id]);
                    }
                }catch(Exception $e)
                {
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('change_student_password',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('change_student_password',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('change_student_password', [
                'model' => $model,
            ]);
        }


    }


}
