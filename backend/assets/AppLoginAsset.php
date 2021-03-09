<?php

namespace backend\assets;

use yii\web\AssetBundle;


class AppLoginAsset extends AssetBundle
{

    public $css = [
        'css/login.css',
    ];

    public $depends = [
        AppAsset::class
    ];

    public $publishOptions = [
        'forceCopy' => YII_ENV_DEV
    ];
}
