<?php

namespace common\helper;

use common\models\settings\Setting as Model;
use yii\base\Component;

/**
 * Class Setting
 *
 * @package common\helper
 */
class Setting extends Component
{

    /**
     * @var Model
     */
    private $_value;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->_value = new Model();
        $this->_value->getValues();
        parent::init();
    }

    public function get()
    {
        return $this->_value;
    }
}
