<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
?>

<div class="col-sm-12">
	<div class="tabbable">
		<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
			<li class="active"><a data-toggle="tab" href="#common">普通模式</a></li>
			<li class=""><a data-toggle="tab" href="#oneKey">一键绑定模式</a></li>
		</ul>

		<div class="tab-content">
			<div id="common" class="tab-pane active">
			<h4 class="page-header">普通模式</small></h4>
			<?php 
			 $model->setScenario('normal');
			?>
			<?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>
    <?= Html::hiddenInput('isNormal','normal')?>
    <?= $form->field($model, 'name')->hint('您可以给此公众号起一个名字, 方便下次修改和查看')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'type')->dropDownList(['0'=>'微信公众平台','1'=>'易信公众平台'])->label('公众号类型')?>
    <?= $form->field($model, 'level')->dropDownList(['0'=>'普通订阅号','1'=>'认证订阅号/普通服务号','2'=>'认证服务号'])->label('公众号接口权限') ?>
    <?= $form->field($model, 'key')->label('公众号AppId')->hint('请填写微信公众平台后台的AppId')?>
    <?= $form->field($model, 'secret')->label('公众号AppSecret')->hint('请填写微信公众平台后台的AppSecret, 只有填写这两项才能管理自定义菜单')?>
    <?= $form->field($model, 'account')->hint('您的微信帐号或是易信帐号，本平台支持管理多个公众号')?>
    <?= $form->field($model, 'original')->label('原始帐号')->hint('微信公众帐号的原ID串，'.HTML::a('怎么查看微信的原始帐号？',['index','act'=>'help'], ['target'=>'blank']))?>
    <?php if(empty($model->id)){?>
    <?= $form->field($model, 'qrcode_img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*','multiple' => true]
])->label('二维码');?>
    <?= $form->field($model, 'header_img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*','multiple' => true]
])->label('头像');?>
    
    <?php }else {?>
    <?= $form->field($model, 'qrcode_img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*','multiple' => true],'pluginOptions' => [
        'initialPreview'=>[
            Html::img(yii::$app->urlManager->createAbsoluteUrl($model->qrcode_img != null ?"{$model->qrcode_img}":'upload/default.jpg'), ['class'=>'file-preview-image']),
                ],
        'uploadExtraData' => [
            'album_id' => 20,
            'cat_id' => 'Nature'
        ],
        'maxFileCount' => 10
    ]
])->label('二维码');?>
    
    <?= $form->field($model, 'header_img')->widget(FileInput::classname(), [
    'options' => ['accept' => 'image/*','multiple' => true],'pluginOptions' => [
        'initialPreview'=>[
            Html::img(Yii::$app->urlManager->createUrl($model->header_img != null?"{$model->header_img}":'upload/default.jpg'), ['class'=>'file-preview-image']),
                ],
        'uploadExtraData' => [
            'album_id' => 20,
            'cat_id' => 'Nature'
        ],
        'maxFileCount' => 10
    ]
])->label('头像');?>
    <?php }?>

    <div class="form-group">
     <div class="col-sm-offset-3 col-sm-9">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
   </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
			<div id="oneKey" class="tab-pane">
			<h4 class="page-header">一键绑定模式 <small>设置用户名密码后，程序会自动采集您的公众号相关信息。</small></h4>
			<?php 
			 $model->setScenario('onekey');
			?>
			<?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>
			<?= Html::hiddenInput('isNormal','onekey')?>
			<?= $form->field($model, 'type')->dropDownList(['1'=>'微信公众平台','2'=>'易信公众平台'])->label('公众号类型')?>
			<?= $form->field($model, 'username')->hint('请输入你的公众平台用户名')->textInput(['maxlength' => true])?>
    		<?= $form->field($model, 'password')->hint('请输入你的公众平台密码')->textInput(['maxlength' => true])?>
    		<div class="form-group field-publicaccount-password">
<label class="control-label col-sm-3" for="publicaccount-password"></label>
<div class="col-sm-9">
<?= Html::label('温馨提示：如发现获取失败，很有可能是验证码错误或账户密码错误（注意不要带空格）',null,['style'=>'color:red'])?>
</div>
</div>
     <div class="form-group">
     <div class="col-sm-offset-3 col-sm-9">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', '创建') : Yii::t('app', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-default']) ?>
   </div>
    </div>
    <?php ActiveForm::end(); ?>
												</div>
		</div>
	</div>
	</div>