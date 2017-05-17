<?php
$this->pageTitle = '点评编辑';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
        <div class="form-body">
            <div class="form-group">
                <label class="col-md-2 control-label">被点评帐号<span class="required" aria-required="true">*</span></label>
                <div class="col-md-4">
                    <?php echo $form->dropDownList($model,'sid', $staffs, array('class'=>'form-control')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($model, 'sid'); ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">点评内容</label>
                <div class="col-md-4">
                    <?php echo $form->textArea($model,'content',array('class'=>'form-control','rows'=>'13')); ?>
                </div>
                <div class="col-md-2"><?php echo $form->error($model, 'content') ?></div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">状态</label>
                <div class="col-md-4 radio-list">
                    <?php echo $form->radioButtonList($model, 'status', StaffCommentExt::getStatus(), ['class'=>'form-control','separator'=>'&nbsp;','template'=>'{input}{label}']); ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回',$this->createUrl('commentList'),array('class'=>'btn default')) ?>
                </div>
            </div>
        </div>
    <?php $this->endWidget(); ?>
</div>
