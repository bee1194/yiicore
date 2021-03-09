<?php

namespace backend\controllers;

use common\helper\Status;
use common\helper\StatusBehavior;
use common\models\Permission;
use common\models\Role;
use common\models\RolePermission;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class RoleController
 *
 * @package backend\controllers
 */
class RoleController extends Controller
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
                        'permissions' => ['role index'],
                    ],
                    [
                        'actions' => ['create', 'update', 'status'],
                        'allow' => TRUE,
                        'permissions' => ['role upsert'],
                    ],
                    [
                        'actions' => ['permission'],
                        'allow' => TRUE,
                        'permissions' => ['role permission'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => TRUE,
                        'permissions' => ['role delete'],
                    ],
                ],
            ]
        ];

        return ArrayHelper::merge(parent::behaviors(), $behaviors);
    }

    /**
     * Lists all Role models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Role::find()
            ->alias('role')
            ->joinWith(['author author', 'updater updater']);
        $filter = Yii::$app->request->get();
        if (!empty($filter['name'])) {
            $query->andFilterWhere(['LIKE', 'name', $filter['name']]);
        }
        if (!isset($filter['state'])) {
            $filter['state'] = '';
        }
        if ($filter['state'] != -1) {
            $query->andFilterWhere(['role.status' => $filter['state'] ?? NULL]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filter' => $filter
        ]);
    }

    /**
     * @param $id
     *
     * @return Role|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== NULL) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new Role();
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Create successful');
            return $this->redirect(['role/index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Update successful');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws Throwable
     * @throws StaleObjectException
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return string
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionPermission()
    {
        $roles = Role::find()->andWhere(['status' => StatusBehavior::STATUS_ACTIVE])->all();
        $permissions = Permission::find()
            ->joinWith(['children child'])
            ->where([Permission::tableName() . '.parent_id' => NULL])->all();

        if ($post = Yii::$app->request->post('access')) {
            $permission_data = [];

            foreach ($post as $role => $item) {
                $permission_deleted = RolePermission::deleteAll(['role_id' => $role]);

                foreach ($item as $permission_id => $value) {
                    if ($value == 1) {
                        $permission_data[] = new RolePermission([
                            'role_id' => $role,
                            'permission_id' => $permission_id
                        ]);
                    }
                }
            }

            if (!empty($permission_data)) {
                $upsert = RolePermission::updatePermission($permission_data);
            }

            if (!empty($upsert) || !empty($permission_deleted)) {
                Yii::$app->session->setFlash('success', 'Update successful');
            }

            return $this->refresh();
        }


        return $this->render('permission', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionStatus()
    {
        $id = Yii::$app->request->post('request');
        $model = $this->findModel($id);
        $model->status = ($model->status == Status::STATUS_ACTIVE) ? Status::STATUS_INACTIVE : Status::STATUS_ACTIVE;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Update successful');

            return $this->redirect(['role/index']);
        } elseif ($errors = $model->errors) {
            foreach ($errors as $error) {
                Yii::$app->session->setFlash('error', $error[0]);
            }
        }

        return $this->redirect(['role/index']);
    }
}
