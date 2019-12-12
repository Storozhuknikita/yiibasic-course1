<?php
/**
 * Задание Урок 4
 * 1. Мы создали таблицу для сущности activity. Вам нужно создать оставшиеся таблицы.
    * a.Пользователи ( * внимательно посмотрите на встроенную систему авторизации и то, как в ней устроены модели пользователей. Мы разберём её в следующей лекции, но можно забежать чуть вперёд).
    * b. Связка пользователей и событий.
    * c. * Какие ещё сущности будут нужны для проекта?
 * 2. Создайте миграции для всех перечисленных Вами сущностей.
 */

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

        return $this->render('forms', ['model' => $model]);
    }


    public function actionFillDb(){
        for($i=0; $i<10; $i++){
            try {
                \Yii::beginProfile("title $i", 'testing'); //
                \Yii::beginProfile("title $i 1", 'testing'); //
                \Yii::beginProfile("title $i 2", 'testing'); //

                \Yii::$app->db->beginTransaction();
                $query = \Yii::$app->db->createCommand()->insert('activity', [
                    'title' => "title $i",
                    'created_at' => time(),
                    'started_at' => time() + $i * 60 * 60 * 24,
                    'finished_at' => time() + ($i + 1) * 60 * 60 * 24,
                    'cycle' => false,
                    'main' => false,
                    'user_id' => $i
                ]);

                print_r($query->getRawSql() . '<br/>');
                $query->execute();

                \Yii::endProfile("title $i", 'testing'); //
                \Yii::endProfile("title $i 1", 'testing'); //
                \Yii::endProfile("title $i 2", 'testing'); //

                \Yii::$app->db->transaction->commit();
            } catch (\Throwable $exception){
                \Yii::$app->db->transaction->rollBack();

            }

            /*if($i>5){
                \Yii::$app->db->transaction->commit();
            }else{
                \Yii::$app->db->transaction->rollBack();
            }*/
        }

        return $this->render('world');

    }

    public function actionQuery($id){

        $query = \Yii::$app->db->createCommand('SELECT * FROM activity WHERE id > :id')->bindValue(':id', $id);
        echo $query->getRawSql();

        $result = $query->queryAll();

        var_dump($result);
        die;
    }


    public function actionUpdate($id){

        $query = \Yii::$app->db->createCommand()->update('activity',
            ['id'=> $id, 'title'=>'updated_at', 'updated_at' => time()],
            'id=:id', ['id' => $id]);

        echo $query->getRawSql();
        $query->execute();

    }




}