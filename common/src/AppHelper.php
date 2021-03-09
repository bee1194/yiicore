<?php

namespace common\src;

use common\models\settings\Setting;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Class AppHelper
 *
 * @package common\src
 */
class AppHelper extends BaseObject
{

    /**
     * @return Setting
     * @throws InvalidConfigException
     */
    public static function setting()
    {
        return Yii::$app->get('setting')->get();
    }
}
