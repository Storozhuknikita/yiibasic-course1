<?php

namespace app\behaviors;
use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class ActiveRecordCache
 * @package app\behaviors
 */
class ActiveRecordCache extends Behavior
{
    public $cacheKeyName;
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'deleteCache',
            ActiveRecord::EVENT_AFTER_UPDATE => 'deleteCache',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteCache',
            ActiveRecord::EVENT_AFTER_FIND => 'setCache',
        ];
    }

    public function setCache() {
        \Yii::$app->cache->set( get_class($this->owner) . '_' . $this->owner->id, $this->owner );
    }

    public function deleteCache()
    {
        \Yii::$app->cache->delete($this->cacheKeyName . "_" . $this->owner->getPrimaryKey());
        $this->owner->title = 'uviuvideluvideluvideldel';
    }
}