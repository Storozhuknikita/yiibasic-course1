<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property string $title
 * @property int $started_at
 * @property int $finished_at
 * @property int $author_id
 * @property int $main
 * @property int $cycle
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $author
 * @property Calendar[] $calendars
 * @property User[] $users - cписок всех пользователей из календаря
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @return array
     * Behaviors
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time()
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['started_at', 'finished_at', 'author_id', 'main', 'cycle', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            /**
             * Доп условие для проверки
             * Задание 3.1, 3.2
             */
            ['finished_at', 'default', 'value' => function($model, $attribute) {
                return $model->started_at;   }],
            ['finished_at', 'compare', 'compareAttribute' =>
                'started_at', 'operator' => '>=', 'type' => 'number'],

            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'title' => 'Название',
            'started_at' => 'Дата и время начала',
            'finished_at' => 'Finished At',
            'author_id' => 'Author ID',
            'main' => 'Блокируеще?',
            'cycle' => 'Повторятеся?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
        return $this->hasMany(Calendar::className(), ['activity_id' => 'id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->via('calendar');
    }

}
