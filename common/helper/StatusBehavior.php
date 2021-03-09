<?php


namespace common\helper;


use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;

/**
 * Class StatusBehavior
 *
 * @package common\helper
 */
class StatusBehavior extends AttributeBehavior
{

    const STATUS_DELETED = -10;

    const STATUS_INACTIVE = 0;

    const STATUS_ACTIVE = 10;

    const STATES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive'
    ];

    public $status_attribute = 'status';
    public $value;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->status_attribute]
            ];
        }
    }

    /**
     * @param \yii\base\Event $event
     *
     * @return int|mixed
     */
    protected function getValue($event)
    {
        if ($this->value === NULL) {
            if (!isset($this->owner->status)) {
                return self::STATUS_ACTIVE;
            }

            return $this->owner->status;
        }

        return parent::getValue($event);
    }
}