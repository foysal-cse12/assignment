<?php 
    namespace app\models;
    
    use Yii;
    use yii\base\Model;
    use app\models\Users;
    
    class StudentPasswordForm extends Model{
        public $password; 
        
        public function rules(){
            return [
                [['password'],'required'],
                [['password'], 'string', 'min' => 5],
            ];
        }
      
        
        public function attributeLabels(){
            return [
                'password'=>'Password',
                
            ];
        }
    }