<?php
/**
 * Created by PhpStorm.
 * User: mihail
 * Date: 02.11.15
 * Time: 13:15
 */

namespace podtserkovsky\userdblog\behaviors;


use podtserkovsky\userdblog\models\UserDbLog;
use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class UserDbLogBehavior extends Behavior
{
    const GUEST = 0;
    /**
     * @var UserDbLog
     */
    private $log;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'prepareLog',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'prepareLog',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveLog',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveLog',
        ];
    }

    /**
     * Prepare log of modifications.
     *
     * @param $event Event
     */
    public function prepareLog($event)
    {
        $log = new UserDbLog();
        /** @var ActiveRecord $sender */
        $sender = $event->sender;
        $log->entity = $sender::className();
        $userId = !empty(Yii::$app->user) ? Yii::$app->user->identity->getId() : self::SCRIPT;
        $log->user_id = $userId;
        $log->event = $event->name;
        $attributes = [];
        foreach($sender->dirtyAttributes as $attribute => $newValue){
            if(is_array($newValue)) continue;
            $attributes[$attribute]['old'] = ArrayHelper::getValue($sender->oldAttributes, $attribute);
            $attributes[$attribute]['new'] = $newValue;
        }
        $log->attributes = $attributes;
        $this->log = $log;

    }

    /**
     * After save $event->sender, save log data.
     *
     * @param $event Event
     */
    public function saveLog($event)
    {
        /** @var ActiveRecord $sender */
        $sender = $event->sender;
        $this->log->entity_id = $sender->getPrimaryKey();
        if(!empty($this->log->attributes)) $this->log->save();
    }
}