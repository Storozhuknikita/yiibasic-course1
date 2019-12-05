<?php

namespace app\models\tasks;

class TasksForm extends \yii\base\Model {

    public $name;
    public $description;
    public $deadline;

    public  function rules(){

        return [
            [['name', 'description', 'deadline'], 'required'],
            [['name', 'description', 'deadline'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Заголовок',
            'description' => 'Описание задачи',
            'deadline' => 'Дедлайн'
        ];
    }


}