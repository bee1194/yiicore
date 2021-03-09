<?php

namespace common\models;

use common\helper\StatusBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%role}}".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $is_primary
 * @property int $created_by
 * @property int $created_at
 * @property int $updated_by
 * @property int $updated_at
 *
 * @property RolePermission[] $rolePermissions
 * @property UserRole[] $userRoles
 * @property User[] $users
 * @property Permission[] $permissions
 * @property User $author
 * @property User $updater
 */
class Role extends ActiveRecord
{

    const IS_PRIMARY = 1;

    const NOT_PRIMARY = 0;

    const ADMIN_ROLE_ID = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'is_primary', 'created_by',
                'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Role Name'),
            'status' => Yii::t('common', 'Status'),
            'is_primary' => Yii::t('common', 'Is Primary'),
            'created_by' => Yii::t('common', 'Created By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['status'] = StatusBehavior::class;

        return $behaviors;
    }

    /**
     * @return ActiveQuery
     */
    public function getRolePermissions()
    {
        return $this->hasMany(RolePermission::class, ['role_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRole::class, ['role_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->via('userRoles');
    }

    /**
     * @return ActiveQuery
     */
    public function getPermissions()
    {
        return $this->hasMany(Permission::class, ['id' => 'permission_id'])
            ->via('rolePermissions');
    }

    /**
     * @param $permission_name
     *
     * @return bool
     */
    public function hasPermission($permission_name)
    {
        $permissions = ArrayHelper::getColumn($this->permissions, 'name');
        if (in_array($permission_name, $permissions)) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id === self::ADMIN_ROLE_ID;
    }
}
