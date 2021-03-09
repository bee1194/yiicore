<?php

namespace common\src;

use yii\web\UrlManager as Base;

/**
 * Class UrlManager
 *
 * @package common\src
 */
class UrlManager extends Base
{

    public $showScriptName = FALSE;

    public $enablePrettyUrl = TRUE;

    public $rules = [
        '<controller:[a-z0-9\-]+>/<id:\d+>' => '<controller>/index',
        '<controller:[a-z0-9\-]+>' => '<controller>/index',
        '<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/<id:\d+>' => '<controller>/<action>',
        '<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>' => '<controller>/<action>',
        '<module:[a-z0-9\-]+>/<controller:[a-z0-9\-]+>/<id:\d+>' => '<module>/<controller>/index',
        '<module:[a-z0-9\-]+>/<controller:[a-z0-9\-]+>' => '<module>/<controller>/index',
        '<module:[a-z0-9\-]+>/<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
        '<module:[a-z0-9\-]+>/<controller:[a-z0-9\-]+>/<action:[a-z0-9\-]+>' => '<module>/<controller>/<action>',
    ];
}
