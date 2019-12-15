<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\search\UserSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    private $password;
    private $email;
    private $username;


    /**
     * @return array
     * Доступ
     */
    public function behaviors()
    {
        /**
         * Нужно будет разделить права для админа и для пользователей.
         * По ошибке использовал 1 контролер
         * Сейчас есть дырка. Любой пользователь может отредактировать любого пользователя
         */
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'submit'],
                        'roles' => ['admin']
                    ],
                    [
                        'actions' => ['profile', 'calendar', 'update', 'view'],
                        'allow' => true,
                    ],
                ],
            ]
        ];
    }


    /**
     * @return string
     * @throws NotFoundHttpException
     * Профиль пользователя
     */
    public function actionProfile() {
        $model = User::findOne( [ 'id' => Yii::$app->user->id ]);
        if ( $model ) {
            return $this->render('profile', [
                'model' => $model,
            ]);
        }
        throw new NotFoundHttpException();
    }

    /**
     * @return string
     * Календарь пользователя
     */
    public function actionCalendar() {
        return $this->render('calendar', ['user' => Yii::$app->user]);
    }

    /**
     * {@inheritdoc}
     * Названия полей
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }



    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new User();

        $user_data = Yii::$app->request->post('User');

        $model->username = $user_data['username'];
        $model->email = $user_data['email'];
        $user_data['password'] = Yii::$app->getSecurity()->generateRandomString(10);

        $model->setPassword($user_data['password']);

        /**
         * Сделать функцию отправки пароля на почту
         */
        $model->generateAuthKey();
        $model->created_at = time();
        $model->updated_at = time();

        if ($model->save()){
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



}
