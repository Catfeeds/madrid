<?php
$this->pageTitle = '点评编辑';
$this->breadcrumbs = array($this->pageTitle);
 ?>
<div class="portlet-body">
     <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
     <div class="form-body">
         <div class="form-group">
             <label class="col-xs-3 control-label">买房顾问<span class="required" aria-required="true">*</span></label>
             <div class="col-xs-5">
                 <?php echo $form->dropDownList($model, 'sid', $staffs, array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'sid') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">点评内容<span class="required" aria-required="true">*</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textArea($model, 'content', array('rows'=>5,'class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'content') ?></div>
         </div>

         <div class="form-group">
             <label class="col-xs-3 control-label"></label>
             <div class="col-xs-5">
                 <button type="submit" class="btn green">保存</button>
                 <?php echo CHtml::link('返回', $this->createUrl('commentList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
             </div>
         </div>

     </div>
     <?php $this->endWidget(); ?>
 </div>
