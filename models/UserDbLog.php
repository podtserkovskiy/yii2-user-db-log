<?php

namespace podtserkovsky\userdblog\models;

use baibaratsky\yii\behaviors\model\SerializedAttributes;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user_db_log".
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entity_id
 * @property integer $user_id
 * @property string $event
 * @property array $attributes
 * @property string $created_at
 *
 * @property IdentityInterface $user
 */
class UserDbLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_db_log';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => SerializedAttributes::className(),
                'attributes' => ['attributes'],
                'encode'=> true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entity_id', 'event'], 'required'],
            [['entity_id', 'user_id'], 'integer'],
            [['created_at', 'attributes'], 'safe'],
            [['entity', 'event'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity ID',
            'user_id' => 'User ID',
            'event' => 'Event',
            'attributes' => 'Attributes',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        $user = Yii::$app->user->identity;
        return $this->hasOne($user::className(), ['id' => 'user_id']);
    }
}
