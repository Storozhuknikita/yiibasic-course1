<?php
namespace app\controllers;

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

}