<?php
$this->pageTitle = $model->plot->title.'-楼盘评测';
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
         <?php foreach(PlotEvaluateExt::$contentFields as $field): ?>
         <div class="form-group">
             <label class="col-xs-3 control-label">缩略图<?php echo $form->label($model,$field); ?><span class="required" aria-required="true">*</span></label>
             <div class="col-xs-5">
                 <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>$field.'[image]','mode'=>2,'width'=>300)) ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, $field.'[image]') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">分析<?php echo $form->label($model,$field); ?><span class="required" aria-required="true">*</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textArea($model, $field.'[content]', array('rows'=>5,'class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, $field.'[content]') ?></div>
         </div>
         <?php endforeach; ?>
         <div class="form-group">
             <label class="col-xs-3 control-label"></label>
             <div class="col-xs-5">
                 <button type="submit" class="btn green">保存</button>
             </div>
         </div>

     </div>
     <?php $this->endWidget(); ?>
 </div>
