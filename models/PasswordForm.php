<?php 
    namespace app\models;
    
    use Yii;
    use yii\base\Model;
    use app\models\Users;
    
    class PasswordForm extends Model{
        public $oldpass;
        public $newpass;
        public $repeatnewpass;
        public $check; 
        
        public function rules(){
            return [
                [['oldpass','newpass','repeatnewpass'],'required'],
                [['newpass','repeatnewpass'], 'string', 'min' => 5],
                ['oldpass','findPasswords'],
                ['repeatnewpass','compare','compareAttribute'=>'newpass'],
            ];
        }
        
        public function findPasswords($attribute, $params){
            $users = new Users();
            $user = Users::find()->where([
                'username'=>Yii::$app->user->identity->username
            ])->one();
            $password = $user->password;
            if (password_verify($this->oldpass, $password)==False) 
            {
                $this->addError($attribute,'Old password is incorrect');
            }

            /*if($password!=$this->oldpass)
                $this->addError($attribute,'Old password is incorrect');*/
        }

        
        public function attributeLabels(){
            return [
                'oldpass'=>'Old Password',
                'newpass'=>'New Password',
                'repeatnewpass'=>'Repeat New Password',
            ];
        }
    }