<?php
/**
 *	  ┏┓　　　┏┓
 *	┏┛┻━━━┛┻┓
 *	┃　　　　　　　┃
 *	┃　　　━　　　┃
 *	┃　┳┛　┗┳　┃
 *	┃　　　　　　　┃
 *	┃　　　┻　　　┃
 *	┃　　　　　　　┃
 *	┗━┓　　　┏━┛
 *	    ┃　　　┃   神兽保佑
 *	    ┃　　　┃   代码无BUG！
 *	 	 ┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */
use yii\grid\SerialColumn;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
$this->params['breadcrumbs'] = [
    '用户管理',
];
?>

<?php
Modal::begin([
    'id'=>'md',
    'header' => '<h2>添加用户</h2>',
    'footer'=>'<button type="button" class="btn btn-primary" onclick="sbmt()">确定</button>',
]);
$form = ActiveForm::begin([
    'id'=>'userform',
    'action'=>'adduser',
    'type'=>ActiveForm::TYPE_HORIZONTAL,
    'validationUrl'=>'ajaxvalidate',
])
?>

<?= $form->field($model,'username',['enableAjaxValidation'=>true])->textInput() ?>
<?= $form->field($model,'password')->passwordInput() ?>
<?= $form->field($model,'password_repeat')->passwordInput() ?>

<?php
$form->end();
Modal::end();
?>
<p>
    <?= \yii\helpers\Html::button('添加用户',[
        'class'=>'btn btn-sm btn-success',
        'onclick'=>'$("#md").modal();'
    ]) ?>
</p>
<?= \yii\grid\GridView::widget([
    'dataProvider'=>$dataprovider,
    'columns'=>[
        ['class' => SerialColumn::className()],
        'username',
        'password',
        [
            'class'=>'yii\grid\ActionColumn'
        ],
    ],
]) ?>
<script>
    function sbmt()
    {
        $('#userform').submit();
    }
</script>