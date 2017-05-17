<?php 
$this->pageTitle = '修改密码';
$this->breadcrumbs = array($this->pageTitle);
?>
<?php $this->widget('AdminTip') ?>
	<?php $form = $this->beginWidget('AdminForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
		<div class="form-group">
			<label class="col-md-3 control-label">用户<span class="required" aria-required="true">*</span></label>
			<div class="col-md-4">
				<?php echo CHtml::tag('div',array('class'=>'form-control'),$user->username) ?>
			</div>
			<div class="col-md-2"><?php echo $form->error($user, 'password') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">原密码<span class="required" aria-required="true">*</span></label>
			<div class="col-md-4">
				<?php echo $form->passwordField($user, 'password',array('class'=>'form-control','value'=>'','placeholder'=>'请输入原密码')) ?>
			</div>
			<div class="col-md-2"><?php echo $form->error($user, 'password') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">新密码<span class="required" aria-required="true">*</span></label>
			<div class="col-md-4">
				<?php echo $form->passwordField($user, 'pwd1',array('class'=>'form-control','placeholder'=>'请输入新密码','value'=>'')) ?>
			</div>
			<div class="col-md-2"><?php echo $form->error($user, 'pwd1') ?></div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label">确认新密码<span class="required" aria-required="true">*</span></label>
			<div class="col-md-4">
				<?php echo $form->passwordField($user, 'pwd2',array('class'=>'form-control','placeholder'=>'请输入新密码','value'=>'')) ?>
			</div>
			<div class="col-md-2"><?php echo $form->error($user, 'pwd2') ?></div>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">确认修改</button>
					<?php echo CHtml::link('返回',$this->createUrl('list'),array('class'=>'btn default')) ?>
				</div>
			</div>
		</div>
<?php $this->endWidget(); ?>