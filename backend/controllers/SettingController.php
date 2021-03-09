<?php

namespace backend\controllers;

use common\models\settings\General;
use common\src\AppHelper;
use ReflectionException;
use Yii;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Class SettingController
 * @package backend\controllers
 */
class SettingController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['allow' => TRUE]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws ReflectionException
     * @throws InvalidConfigException
     */
    public function actionGeneral()
    {
        $model = AppHelper::setting()->model(General::class);
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Updated Successful');
            return $this->refresh();
        }

        return $this->render('general', ['model' => $model]);
    }
}
