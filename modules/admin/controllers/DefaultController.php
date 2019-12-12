<?php

/**
 *
 */
namespace app\modules\admin\controllers;

use yii\helpers\Url;

class DefaultController extends \yii\web\Controller
{

    public function actionIndex()
    {
        if (\Yii::$app->user->can('admin')) {
            return $this->render('index');
        } else \Yii::$app->response->redirect(Url::to('/yiibasic-course1/web/'));
    }

}