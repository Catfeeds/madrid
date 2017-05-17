<?php 
$this->pageTitle = '角色编辑';
$this->breadcrumbs = array($this->pageTitle);
?>

<form action="" method="post">
<div class="row">
	<div class="col-md-12">
		<div class="h4 font-purple-plum">
			<i class="icon-speech font-purple-plum"></i>
			<span class="caption-subject bold uppercase">用户组：</span>
		</div>
			组名
			<?php echo CHtml::textField('Role[chinese]', empty($role->chinese)?'':$role->chinese, array('class'=>'form-control input-inline input-medium', 'readonly'=>!empty($role))); ?>
			描述
			<?php echo CHtml::textField('Role[description]',empty($role->description)?'':$role->description, array('class'=>'form-control input-inline input-medium')); ?>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<div class="h4 font-purple-plum">
			<i class="icon-speech font-purple-plum"></i>
			<span class="caption-subject bold uppercase">选择操作</span>
		</div>
		<?php 
			foreach($tasks as $task): 
				$operations = $task->getChildren();
		?>
		<div class="portlet-body flip-scroll">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo $task->chinese; ?></h3>
				</div>
				<div class="panel-body">
					<?php 
						foreach($operations as $operation)
						{
							echo CHtml::checkBox('operations[]',isset($selected[$operation->name]),array('return'=>'true','value'=>$operation->name));
							echo CHtml::tag('span',array('class'=>'tooltips','data-original-title'=>$operation->description), $operation->chinese);
						}
					?>
				</div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
<div class="row">
	<div class="col-md-offset-3 col-md-9">
		<button type="submit" class="btn green">保存</button>
		<?php echo CHtml::link('返回',$this->createUrl('list'),array('class'=>'btn default')) ?>
	</div>
</div>
</form>
