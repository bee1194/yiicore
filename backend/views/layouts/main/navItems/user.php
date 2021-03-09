<?php
/**
 * @var View $this
 */

use yii\helpers\Html;
use yii\web\View;

$sidebar = 'sidebarUsers';
$route = 'user/index';
?>
<li class="nav-item">
    <?= Html::a("<i class='fe fe-users'></i> User",
        "#$sidebar",
        [
            'class' => "nav-link",
            'data-toggle' => "collapse",
            'role' => "button",
            'aria-expanded' => ($this->isController('user') ? 'true' : 'false'),
            'aria-controls' => $sidebar
        ]) ?>
    <?= Html::beginTag('div', [
        'class' => 'collapse' . ($this->isController('user') ? ' show' : NULL),
        'id' => $sidebar
    ]) ?>
    <ul class="nav nav-sm flex-column">
        <li class="nav-item">
            <?= Html::a('User', [$route], [
                'class' => 'nav-link' . ($this->isController('user') ? ' active' : NULL)]) ?>
        </li>
    </ul>
    <?= Html::endTag('div') ?>
</li>
