<?php
/**
 * @var $this yii\web\View
 * @var string $link_btn
 * @var string $overview
 */

use common\widgets\Alert;
use yii\helpers\Html;

?>
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <?php if (!empty($overview)): ?>
                        <h6 class="header-pretitle text-secondary">
                            <?= Html::encode($overview) ?>
                        </h6>
                    <?php endif; ?>
                    <h1 class="header-title">
                        <?= Html::encode($this->title) ?>
                    </h1>
                </div>
                <?php if (!empty($link_btn)): ?>
                    <div class="col-auto">
                        <?= $link_btn ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?= Alert::widget([
            'options' => [
                'class' => 'mt-4 mb-4'
            ]
        ]) ?>
    </div>
</div>

