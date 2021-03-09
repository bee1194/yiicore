<?php

namespace common\helper;

use Yii;
use yii\base\BaseObject;

/**
 * Class SocialMediaTags
 *
 * @package common\helper
 */
class SocialMediaTags extends BaseObject
{

    /**
     * @param $properties
     */
    public static function generate($properties)
    {
        foreach ($properties as $item => $value) {
            Yii::$app->view->registerMetaTag([
                'property' => $item,
                'content' => $value,
            ]);
        }
    }
}
