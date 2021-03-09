<?php
/**
 * @var \yii\web\View $this
 */

use app\assets\AppAsset;
use yii\helpers\Html;

?>
<div class="mt-auto"></div>
<div class="navbar-user d-none d-md-flex" id="sidebarUser">
    <div class="dropup">
        <?= Html::beginTag('a', [
            'href' => ['#'],
            'id' => 'sidebarIconCopy',
            'class' => 'dropdown-toggle',
            'role' => 'button',
            'data-toggle' => 'dropdown',
            'aria-haspopup' => 'true',
            'aria-expanded' => 'false'
        ]) ?>
        <div class="avatar avatar-sm avatar-online">
            <?= Html::img('/img/hia-sq.png', [
                'class' => 'avatar-img rounded-circle',
                'alt' => '...'
            ]) ?>
        </div>
        <?= Html::endTag('a') ?>
        <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
            <?= Html::a('Logout', ['site/logout'], [
                'class' => 'dropdown-item',
                'data-method' => 'post'
            ]) ?>
        </div>
    </div>
</div>
