<?php

namespace app\models;

class HelperForm extends \yii\base\Model {

    public $username;
    public $email;
    public $phone;
    public $sendEmail;

    public  function rules(){

        return [
            [['username', 'phone', 'email'], 'required'],
            [['username', 'phone'], 'string'],
            [['email'], 'email'],
            [['sendEmail'], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Login',
            'phone' => 'Phone',
            'email' => 'Email'
        ];
    }


}