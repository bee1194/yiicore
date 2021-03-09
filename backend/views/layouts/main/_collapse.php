<?php
/**
 * @var \yii\web\View $this
 */

?>
<div class="collapse navbar-collapse" id="sidebarCollapse">
    <ul class="navbar-nav">
        <?= $this->render('navItems/home') ?>
    </ul>
    <hr class="navbar-divider my-3">
    <ul class="navbar-nav">
        <?= $this->render('navItems/user') ?>
        <?= $this->render('navItems/role') ?>
        <?= $this->render('navItems/setting') ?>
    </ul>
    <?= $this->render('__user_desktop') ?>
</div>
