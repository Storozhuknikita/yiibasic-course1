<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Activity;

/**
 * ActivitySearch represents the model behind the search form of `app\models\Activity`.
 */
class ActivitySearch extends Activity
{

    public $authorEmail;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',
                'finished_at',
                'author_id',
                'main',
                'cycle',
                'created_at',
                'updated_at'],
                'integer'],
            [['title'], 'safe'],
            [['authorEmail'], 'string'],
            [['started_at'], 'date', 'format' => 'php:d.m.Y'],
            [['finished_at'], 'date', 'format' => 'php:d.m.Y'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param bool $forCurrentUser
     * @return ActiveDataProvider
     */
    public function search( array $params, bool $forCurrentUser ) {
        $this->load($params);
        $query = Activity::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if ($this->validate()) {
            $query->andFilterWhere([
                'id' => $this->id,
                'started_at' => $this->started_at,
                'finished_at' => $this->finished_at,
                'main' => $this->main,
                'cycle' => $this->cycle,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'author_id' => $forCurrentUser ? \Yii::$app->user->id : $this->author_id
            ])
                ->andFilterWhere(['like', 'title', $this->title]);
        }
        if (!$forCurrentUser && $this->author) {
            $query->joinWith('author as author')
                ->andWhere(['like', 'author.username', $this->author]);
        }
        return $dataProvider;
    }
        /*

//        $query = Activity::find()->joinWith('users')
  //          ->where(['user.id' => \Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        /**
         * Валидация даты. Формируем правильный запрос для поиска. Начало дня и конец дня.
         */
        /*
        if (!empty($this->started_at)) {
            $this->filterByDate('started_at', $query);
        }
        if (!empty($this->finished_at)) {
            $this->filterByDate('finished_at', $query);
        }
        if (!empty($this->authorEmail)) {
            $query->joinWith('author as author');
            $query->andWhere(['like', 'author.email', $this->authorEmail]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'author_id' => $this->author_id,
            'main' => $this->main,
            'cycle' => $this->cycle,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $forCurrentUser ? \Yii::$app->user->id : $this->author_id

        ]);

        if (empty($this->title) && $this->title === '0'){

        }

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
        }
        */

    /**
     * @param $attr
     * @param $query
     *
     */
    private function filterByDate($attr, $query)
    {
        $dayStart = (int)\Yii::$app->formatter->asTimestamp($this->$attr . ' 00:00:00');
        $dayStop = (int)\Yii::$app->formatter->asTimestamp($this->$attr . ' 23:59:59');
        $query->andFilterWhere([
            'between',
            self::tableName() . ".$attr",
            $dayStart,
            $dayStop,
        ]);
    }

}
