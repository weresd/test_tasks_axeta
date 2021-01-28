<?php

namespace app\models\search;

use app\components\DateTimeFormats;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Claim;

/**
 * ClaimSearch represents the model behind the search form of `app\models\Claim`.
 */
class ClaimSearch extends Claim
{
    /**
     * Begin part of end date.
     *
     * @var string
     */
    private $endDateBegin;

    /**
     * End part of end date.
     *
     * @var string
     */
    private $endDateEnd;

    /**
     * Begin part of create date.
     *
     * @var string
     */
    private $createdAtBegin;

    /**
     * End part of create date.
     *
     * @var string
     */
    private $createdAtEnd;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id'], 'integer'],
            [['title'], 'string'],
            [
                ['end_date', 'created_at'],
                'datetime',
                'format' => 'php:' . DateTimeFormats::USER_FORMAT . ' - ' . DateTimeFormats::USER_FORMAT
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     * @throws InvalidConfigException
     */
    public function search($params)
    {
        $query = Claim::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');

            return $dataProvider;
        }

        if (!empty($this->end_date)) {
            list($endDateBegin, $endDateEnd) = explode(' - ', $this->end_date);

            $this->endDateBegin = Yii::$app->formatter->asDatetime(
                $endDateBegin,
                'php:' . DateTimeFormats::DB_FORMAT
            );
            $this->endDateEnd = Yii::$app->formatter->asDatetime(
                $endDateEnd,
                'php:' . DateTimeFormats::DB_FORMAT
            );
        }

        if (!empty($this->created_at)) {
            list($createdAtBegin, $createdAtEnd) = explode(' - ', $this->created_at);

            $this->createdAtBegin = Yii::$app->formatter->asDatetime(
                $createdAtBegin,
                'php:' . DateTimeFormats::DB_FORMAT
            );
            $this->createdAtEnd = Yii::$app->formatter->asDatetime(
                $createdAtEnd,
                'php:' . DateTimeFormats::DB_FORMAT
            );
        }

        $query->andFilterWhere([
            'status_id' => $this->status_id,
        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['>=', 'end_date', $this->endDateBegin])
            ->andFilterWhere(['<=', 'end_date', $this->endDateEnd])
            ->andFilterWhere(['>=', 'created_at', $this->createdAtBegin])
            ->andFilterWhere(['<=', 'created_at', $this->createdAtEnd]);

        return $dataProvider;
    }
}
