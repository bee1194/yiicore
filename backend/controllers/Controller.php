<?php

namespace backend\controllers;

use yii\filters\VerbFilter;

/**
 * Class Controller
 *
 * @package backend\base
 */
class Controller extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
}
