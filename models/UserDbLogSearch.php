<?php

namespace podtserkovsky\userdblog\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;


/**
 * UserDbLogSearch represents the model behind the search form about `podtserkovsky\userdblog\models\UserDbLog`.
 */
class UserDbLogSearch extends UserDbLog
{
    public $userName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'entity_id'], 'integer'],
            [['entity', 'event', 'attributes', 'created_at', 'userName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserDbLog::find();
        $query->joinWith(['user']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'user_db_log.id' => $this->id,
            'user_db_log.entity_id' => $this->entity_id,
            'user_db_log.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'user_db_log.entity', $this->entity])
            ->andFilterWhere(['like', 'user.username', $this->userName])
            ->andFilterWhere(['like', 'user_db_log.event', $this->event])
            ->andFilterWhere(['like', 'user_db_log.attributes', $this->attributes]);

        return $dataProvider;
    }
}
