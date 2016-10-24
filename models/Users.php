<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $user_type
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            /*[['username', 'password', 'email', 'user_type'], 'required'],
            [['username', 'password', 'email', 'user_type'], 'string', 'max' => 255],*/
            [['username', 'password', 'email'], 'required'],
            ['username', 'filter', 'filter' => 'trim'],
            [['username','email'], 'string', 'max' => 255],
            [['user_type'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 5],
            ['email','email'],
             ['email','unique'],
            ['email', 'trim'],

            [['username'], 'unique'],
           

          

        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'user_type' => 'User Role',
        ];
    }

    public static function findIdentity($id)
    {
       /* return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;*/
       return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;*/
        throw new yii\base\NotSupportedException();
    }

    

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }


    

    

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
       /* return $this->authKey;*/
        throw new yii\base\NotSupportedException();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        /*return $this->authKey === $authKey;*/
         throw new yii\base\NotSupportedException();
    }


    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
        return self::findOne(['username'=>$username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
