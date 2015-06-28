<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admin\models\TAdmUser */

$this->title = '更新用户';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tadm-user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
