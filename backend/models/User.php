<?php

namespace backend\models;

use common\helper\Status;
use Yii;
use yii\helpers\Html;

/**
 *
 * @property-read string $viewStatus
 */
class User extends \common\models\User
{

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'role_id' => Yii::t('common', 'Role Name'),
        ];
    }

    /**
     * @return string
     */
    public function getViewStatus()
    {
        if ($this->status == Status::STATUS_ACTIVE) {
            return Html::tag('span', 'Active', [
                'class' => 'badge badge-soft-primary',
            ]);
        }

        return Html::tag('span', 'Inactive', [
            'class' => 'badge badge-soft-secondary',
        ]);
    }
}
