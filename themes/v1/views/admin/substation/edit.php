<?php
$this->pageTitle = '编辑分站信息';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
	<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-2 control-label">分站名称<span class="required" aria-required="true">*</span></label>
				<div class="col-md-4">
					<?php echo $form->textField($model,'name',array('class'=>'form-control')) ?>
				</div>
				<div class="col-md-2"><?php echo $form->error($model, 'name') ?></div>
			</div>
            <div class="form-group">
				<label class="col-md-2 control-label">选择区域设置为分站<span class="required" aria-required="true">*</span></label>
				<div class="col-md-4">
					<?php echo $form->dropDownList($model,'area_id',$areaArr,array('class'=>'form-control')) ?>
				</div>
				<div class="col-md-2"><?php echo $form->error($model, 'area') ?></div>
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
