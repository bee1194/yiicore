<?php

namespace common\models\settings;

use Yii;

/**
 * Class General
 * @package common\models\settings
 */
class General extends Setting
{

    public $name;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['name'], 'required'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('common', 'Name'),
        ];
    }
}
