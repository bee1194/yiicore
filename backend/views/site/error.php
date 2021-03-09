<?php

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception Exception
 */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h6 class="header-pretitle text-secondary">
                        Error </h6>
                    <h1 class="header-title">
                        <?= Html::encode($this->title) ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pb-4">
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <p>The above error occurred while the Web server was processing your request.</p>
    <p>Please contact us if you think this is a server error. Thank you.</p>
</div>
