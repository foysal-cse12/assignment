<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PasswordForm;
use app\models\Users;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','changepassword'],
                'rules' => [
                    [
                        'actions' => ['logout','changepassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            $session = Yii::$app->session;
            $session->open();
            $userid = Yii::$app->user->identity->id;
            $user_type = Yii::$app->user->identity->user_type;
            $session['userid'] = $userid;
            if($user_type === 'teacher')
            {
                 return $this->redirect(['/students/index']);
            }
            else
            {
                //return 'hello student';
                return $this->redirect(['/students/student_view','userid'=>$userid]);
            }

        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        $session = Yii::$app->session;
        unset($session['user_id']);
        //Yii::app()->session->destroy()

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

   
    public function actionChangepassword()
    {
        $model = new PasswordForm();
        $modeluser = Users::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();
       // $modeluser = Yii::$app->user->identity->username;
       // return 'username: '.$modeluser;
      
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate()){
                try{
                    $modeluser->password = $_POST['PasswordForm']['newpass'];
                    $modeluser->password = Yii::$app->security->generatePasswordHash($modeluser->password);
                    if($modeluser->save())
                    {
                        Yii::$app->getSession()->setFlash(
                            'success','Password changed'
                        );
                        //return $this->redirect(['logout']);
                         Yii::$app->user->logout();
                         $session = Yii::$app->session;
                         unset($session['user_id']);
                         return $this->goHome();
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Password not changed'
                        );
                        return $this->redirect(['index']);
                    }
                }catch(Exception $e)
                {
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('changepassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changepassword',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('changepassword',[
                'model'=>$model
            ]);
        }
    }



}
