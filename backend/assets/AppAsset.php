<?php

namespace backend\assets;

use common\widgets\fontfeather\FontFeatherAsset;
use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $css = [
        'css/theme.min.css',
    ];

    public $js = [
        'js/theme.min.js'
    ];

    public $depends = [
        FontFeatherAsset::class,
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset'
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];
}
