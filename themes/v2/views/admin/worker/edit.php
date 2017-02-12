<?php 
$this->pageTitle = '编辑资料';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
	<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-2 control-label">用户名<span class="required" aria-required="true">*</span></label>
				<div class="col-md-4">
					<?php echo $form->textField($user,'username',array('class'=>'form-control','disabled'=>$user->scenario!='insert')) ?>
				</div>
				<div class="col-md-2"><?php echo $form->error($user, 'username') ?></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">密码</label>
				<div class="col-md-4">
					<?php echo $form->passwordField($user,$user->id?'newPwd':'password',array('class'=>'form-control','value'=>'')) ?>
				</div>
				<div class="col-md-2"><?php echo $form->error($user,$user->id?'newPwd':'password') ?></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">用户头像</label>
				<div class="col-md-4">
					<?php $this->widget('FileUpload',array('model'=>$user,'attribute'=>'avatar','inputName'=>'avatar','width'=>300)); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">用户组<span class="required" aria-required="true">*</span></label>
				<div class="col-md-4">
					<!-- group property is object, thus set HtmlOptions 'key' which it's value is 'name' -->
					<?php echo $form->dropDownList($user,'group', $authItems, array('key'=>'name','class'=>'form-control','disabled'=>!Yii::app()->user->checkAccess('admin'))); ?>
					<span class="help-block"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">状态<span class="required" aria-required="true">*</span></label>
				<div class="col-md-4 radio-list">
					<?php echo $form->radioButtonList($user,'status',AdminExt::$status,array('separator'=>'','template'=>'<label>{input} {label}</label>')) ?>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-2 col-md-9">
					<button type="submit" class="btn green">保存</button>
					<?php echo CHtml::link('返回',$this->createUrl('list'),array('class'=>'btn default')) ?>
				</div>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>