<?php

namespace katanyoo\activerecordhistory;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * ActiveRecordLogSearch represents the model behind the search form about `common\models\ActiveRecordLog`.
 */
class ActiveRecordLogSearch extends ActiveRecordLog
{
    public $userName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'user_id', 'created_at'], 'integer'],
            [['description', 'action', 'model', 'field', 'userName'], 'safe'],
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
        $query = ActiveRecordLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'defaultOrder' =>[
                    'created_at' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'model_id' => $this->model_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'field', $this->field]);

        return $dataProvider;
    }
}