<?php

namespace backend\controllers;

use backend\models\User;
use backend\models\UserForm;
use common\helper\StatusBehavior;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class UserController
 *
 * @package backend\controllers
 */
class UserController extends Controller
{

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => TRUE,
                        'permissions' => ['user index'],
                    ],
                    [
                        'actions' => ['create', 'update', 'validate', 'change-status'],
                        'allow' => TRUE,
                        'permissions' => ['user upsert'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => TRUE,
                        'permissions' => ['user delete'],
                    ],
                ],
            ]
        ];

        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    /**
     * @return string
     * SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
     * SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
     */
    public function actionIndex()
    {
        $query = User::find()
            ->alias('user')
            ->joinWith('roles userRole')
            ->distinct();
        $filter = Yii::$app->request->get();
        if (!empty($filter['username'])) {
            $query->andFilterWhere(['LIKE', 'user.username', $filter['username']]);
        }
        if (!empty($filter['user_role'])) {
            $query->andFilterWhere(['role_id' => $filter['user_role']]);
        }
        if (!isset($filter['state'])) {
            $filter['state'] = '';
        }
        if ($filter['state'] != -1) {
            $query->andFilterWhere(['user.status' => $filter['state'] ?? NULL]);
        }
        $data_provider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'username',
                    'email',
                    'status',
                    'created_at',
                    'updated_at',
                    'role_id' => [
                        'ASC' => ['userRole.name' => SORT_ASC],
                        'DESC' => ['userRole.name' => SORT_DESC]
                    ]
                ]
            ]
        ]);

        return $this->render('index', [
            'data_provider' => $data_provider,
            'filter' => $filter,

        ]);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new UserForm();
        $model->scenario = UserForm::SCENARIO_CREATE;
        $post = Yii::$app->request->post();
        if ($post) {
            if ($model->load($post) && $model->create()) {
                Yii::$app->session->setFlash('success', 'Create successful');
                return $this->redirect(['user/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string
     * @throws \yii\base\Exception
     * @throws Exception
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $user_model = new UserForm();

        $user_model->scenario = UserForm::SCENARIO_UPDATE;
        $user_model->setAttributes($model->getAttributes(), FALSE);
        $user_model->user_role_id = ArrayHelper::getColumn($model->roles, 'id');

        $post = Yii::$app->request->post();
        if ($post) {
            if ($user_model->load($post) && $user_model->update()) {
                Yii::$app->session->setFlash('success', 'Update successful');
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('update', [
            'model' => $user_model,
        ]);
    }

    /**
     * @param $id
     *
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== NULL) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionChangeStatus($id)
    {
        $model = $this->findModel($id);
        $status = ($model->status == StatusBehavior::STATUS_ACTIVE) ? StatusBehavior::STATUS_INACTIVE : StatusBehavior::STATUS_ACTIVE;
        $model->status = $status;
        $model->save();
        Yii::$app->session->setFlash('success', 'Update successful');

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = StatusBehavior::STATUS_DELETED;
        $model->save();
        Yii::$app->session->setFlash('success', 'Delete successful');

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionValidate($id = 0)
    {
        if (!empty($id)) {
            $model = $this->findModel($id);
            $user_model = new UserForm();
            $user_model->scenario = UserForm::SCENARIO_UPDATE;
            $user_model->setAttributes($model->getAttributes(), FALSE);
        } else {
            $user_model = new UserForm();
            $user_model->scenario = UserForm::SCENARIO_CREATE;
        }

        if (Yii::$app->request->isAjax && $user_model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($user_model);
        }

        return [];
    }
}
