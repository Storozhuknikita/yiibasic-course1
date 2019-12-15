<?php

/**
 *
 */
namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class DefaultController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'delete', 'update'],
                        'roles' => ['admin']
                    ],
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('admin')) {
            return $this->render('index');
        } else \Yii::$app->response->redirect(Url::to('/yiibasic-course1/web/'));
    }

}