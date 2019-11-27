<?php

namespace app\controllers;

use app\models\HelperForm;
use app\models\tasks\TasksForm;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

class TasksController extends Controller {

    /**
     * @return string
     */
    public function actionIndex(){
        $model = new TasksForm();

        if(\Yii::$app->request->isPost){
            $model = new HelperForm();
            if($model->load(\Yii::$app->request->post())){
                if($model->validate()){ // успешная валидация
                    var_dump($model->attributes);
                }
            }
        }

        return $this->render('index', ['model'=>$model]);
    }
}