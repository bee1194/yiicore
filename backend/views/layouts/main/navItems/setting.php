<?php
/**
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

$sidebar = 'sidebarSetting';
?>
<li class="nav-item">
    <?= Html::a("<i class='fe fe-settings'></i> Setting",
        "#$sidebar",
        [
            'class' => 'nav-link',
            'data-toggle' => 'collapse',
            'role' => 'button',
            'aria-expanded' => (($this->context->id == 'setting') ? 'true' : 'false'),
            'aria-controls' => $sidebar
        ]) ?>
    <?= Html::beginTag('div', [
        'class' => 'collapse' . (($this->context->id == 'setting') ? ' show' : NULL),
        'id' => $sidebar
    ]) ?>
    <ul class="nav nav-sm flex-column">
        <li class="nav-item">
            <?= Html::a('General', ['setting/general'], [
                'class' => 'nav-link' . $this->activeRoute('setting/general')]) ?>
        </li>
    </ul>
    <?= Html::endTag('div') ?>
</li>
