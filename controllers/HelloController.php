<?php
namespace app\controllers;

use app\models\HelperForm;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Controller;

class HelloController extends Controller
{

    /**
     * @return string
     */
    public function actionWorld()
    {
        return $this->render('world');
    }

    public function actionHelpers(){

        /*
        $orders = [
            ['id' => 1, 'price' => 1500],
            ['id' => 22, 'price' => 2500],
            ['id' => 12, 'price' => 3500],
            ['id' => 13, 'price' => 4500],
            ['id' => 14, 'price' => 5500],
            ['id' => 15, 'price' => 6500],
            ['id' => 16, 'price' => 7500],
            ['id' => 17, 'price' => 8500]
        ];

        ArrayHelper::multisort($orders, ['price', 'id'], [SORT_ASC, SORT_DESC]);
        echo'<pre>';
        VarDumper::dump($orders);
        echo'</pre>';
        */
        return $this->render('helpers');
    }

    public function actionForms(){
        $model = new HelperForm();

        if(\Yii::$app->request->isPost){
            $model = new HelperForm();
            if($model->load(\Yii::$app->request->post())){
                if($model->validate()){ // успешная валидация
                    var_dump($model->attributes);
                }
            }
        }

        return $this->render('forms', ['model'=>$model]);
    }

}