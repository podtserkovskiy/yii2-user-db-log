<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel podtserkovsky\userdblog\models\UserDbLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All users db changes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userName' => [
                'attribute' => 'userName',
                'value' => function($model){
                    return empty($model->user) ? 'guest' : $model->user->username;
                },
            ],
            'entity' => [
                'attribute' => 'entity',
                'content' => function($model){
                    $temp = explode('\\', $model->entity);
                    return end($temp);
                },
            ],
            'entity_id' => [
                'attribute' => 'entity_id',
            ],
            'event' => [
                'attribute' => 'event',
                'value' => function($model){
                    switch($model->event){
                        case \yii\db\ActiveRecord::EVENT_BEFORE_INSERT:
                            return 'insert';
                        case \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE:
                            return 'update';
                        default:
                            return '';
                    }
                }
            ],
            'attributes' => [
                'attribute' => 'attributes',
                'content' => function($model){
                    $result = [];
                    foreach($model->attributes as $attributeName => $attributeArray){
                        $result[] = "<span class='label label-info'>$attributeName:</span> "
                                  . "<span class='label label-danger'>{$attributeArray['old']}</span> "
                                  . "<span class='label label-success'>{$attributeArray['new']}</span>";
                    }

                    return implode('<br>', $result);
                },
            ],
            'created_at:datetime',

        ],
    ]); ?>

</div>
