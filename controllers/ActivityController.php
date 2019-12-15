<?php


/**
 * 1. Создайте форму регистрации новых пользователей на сайте.

### 2. Форматы дат могут меняться, поэтому хранить их в коде не лучшая идея. Вынесите форматы дат в конфигурацию. Помните, что захламлять один файл web плохо.
3. Дата окончания события – необязательное поле. Расширьте валидацию модели так, чтобы было следующее.

a. При пустом поле в систему сохранялось значение, равное дате начала.
b. Дата окончания не могла бы быть меньше даты начала.
4. Модифицируйте форму создания события так, чтобы через неё можно было редактировать уже существующие события.

5. * Сделайте так, чтобы для пользователя дата показывалась в формате «день.месяц.год», а в БД продолжала сохраняться в формате MySQL timestamp.
 */
namespace app\controllers;

use edofre\fullcalendar\models\Event;
use PHPUnit\Util\Log\JUnit;
use Yii;
use app\models\Activity;
use app\models\search\ActivitySearch;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends BaseController
{

    public $events;
    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActivitySearch();
        $query = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search( $query, true );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Получение списка активностей для календаря для конкретного пользователя
     * @param int $userId
     * @return array
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEvents( int $userId ) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $activitiesList = Activity::findAll([ 'author_id' => $userId ]);
        $calendarEvents = [];

        if ( $activitiesList && is_array($activitiesList) && count( $activitiesList )) {
            foreach ( $activitiesList as $activity ) {

                $calendarEvents[] = new Event([
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'start' => Yii::$app->formatter->asDatetime($activity->started_at, 'php:Y-m-d H:i:s' ),
                    'end' =>  Yii::$app->formatter->asDatetime($activity->finished_at, 'php:Y-m-d H:i:s' ),

                    'editable'         => true,
                    'startEditable'    => true,
                    'durationEditable' => true,
                    'color'             => 'red',
                    'url' => Url::to(['activity/view', 'id' => $activity->id])
                ]);
            }
        }
        return $calendarEvents;
    }

    /**
     * Displays a single Activity model.
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
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Activity();
        // Врмея создания
        $model->created_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // Время редактирования
        $model->updated_at = time();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
