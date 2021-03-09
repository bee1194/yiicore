<?php

namespace backend\models;

use common\models\Role;
use common\models\UserRole;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class UserForm
 *
 * @package backend\models
 */
class UserForm extends Model
{

    const SCENARIO_CREATE = 'create';

    const SCENARIO_UPDATE = 'update';

    const SCENARIO_CHANGE_PASSWORD = 'change_password';

    public $id;
    public $username;
    public $email;
    public $password;
    public $confirm_password;
    public $user_role_id;
    public $status;
    public $is_change_password = FALSE;

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['email', 'username'], 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username'], 'string'],
            [['username', 'email', 'user_role_id'], 'required'],
            ['user_role_id', 'safe'],
            [
                'email',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.',
                'on' => self::SCENARIO_CREATE
            ],
            [
                'username',
                'unique',
                'targetClass' => '\common\models\User',
                'message' => 'This username has already been taken.',
                'on' => self::SCENARIO_CREATE
            ],
            [['password', 'confirm_password'], 'string', 'min' => 6],
            [['password', 'confirm_password'], 'required', 'on' => self::SCENARIO_CREATE],
            ['confirm_password', 'compare', 'compareAttribute' => 'password'],
            [
                'email',
                'validateDuplicate',
                'message' => 'This email address has already been taken.',
                'on' => self::SCENARIO_UPDATE
            ],
            [
                'username',
                'validateDuplicate',
                'message' => 'This username has already been taken.',
                'on' => self::SCENARIO_UPDATE
            ],
            ['status', 'integer']
        ];

        return $rules;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_role_id' => Yii::t('common', 'Role Name'),
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password', 'confirm_password'];

        return $scenarios;
    }

    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validateDuplicate($attribute, $params, $validator)
    {
        $user = User::find()
            ->andWhere([$attribute => $this->$attribute])
            ->andWhere(['<>', 'id', $this->id])
            ->exists();
        if ($user) {
            $this->addError($attribute, $validator->message);
        }
    }

    /**
     * @return \backend\models\User|null
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function create()
    {
        if (!$this->validate()) {
            return NULL;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        if ($user->save()) {
            $this->id = $user->id;
            $this->updateRole();

            return $user;
        }

        return NULL;
    }

    /**
     * @return \backend\models\User|\backend\models\UserForm|null
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function update()
    {
        if (!$this->validate()) {
            return NULL;
        }

        $user = User::findOne($this->id);
        if ($user) {
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = $this->status;

            //if password not null then create password
            if (!empty($this->password)) {
                $user->setPassword($this->password);
                $user->generateAuthKey();
            }

            if ($user->save()) {
                //delete all role of user before insert roles
                UserRole::deleteAll(['user_id' => $this->id]);
                $this->updateRole();

                return $user;
            }
        }

        return NULL;
    }

    /**
     * @throws \yii\db\Exception
     */
    protected function updateRole()
    {
        if (!empty($this->user_role_id)) {
            $user_roles = [];
            foreach ($this->user_role_id as $role_id) {
                $user_roles[] = new UserRole([
                    'user_id' => $this->id,
                    'role_id' => (int)$role_id
                ]);
            }
            if (UserRole::validateMultiple($user_roles)) {
                Yii::$app->db->createCommand()
                    ->batchInsert(UserRole::tableName(),
                        ['user_id', 'role_id'], $user_roles)
                    ->execute();
            }
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getListRoles()
    {
        $roles = Role::find()->asArray()->all();

        return ArrayHelper::map($roles, 'id', 'name');
    }

    /**
     * @return bool
     */
    public function getIsNewRecord()
    {
        if (empty($this->id)) {
            return TRUE;
        }

        return FALSE;
    }
}
