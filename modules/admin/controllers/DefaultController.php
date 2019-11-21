<?php

/**
 *
 */
namespace app\modules\admin\controllers;

class DefaultController extends \yii\web\Controller
{

    /**
     * @return bool
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}