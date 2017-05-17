<?php
$this->pageTitle = $model->plot->title.'-楼栋编辑';
$this->breadcrumbs = array($this->pageTitle);
 ?>
<div class="portlet-body">
     <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
     <div class="form-body">
         <div class="form-group">
             <label class="col-xs-3 control-label">楼栋号（名称）</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'name', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'name') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">所属期数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->dropDownList($model, 'pid', $periods?$periods:[''=>'请先添加楼盘期数'], array('class'=>'form-control','disabled'=>empty($periods))); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'pid') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">单元数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'unit_total', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'unit_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">规划户数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'household_total', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'household_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">楼层数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'floor_total', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'floor_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">在售房源数</span></label>
             <div class="col-xs-5">
                 <?php echo $form->textField($model, 'sale_total', array('class'=>'form-control')); ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'sale_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">梯户配比</span></label>
             <div class="col-xs-6">
                 <?php echo $form->textField($model, 'liftNum', array('class'=>'form-control input-inline')).'梯'.$form->textField($model, 'houseNum', array('class'=>'form-control input-inline')).'户'; ?>
             </div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">本栋户型</span></label>
             <div class="col-xs-5">
                 <?php echo $houseTypes ? $form->checkBoxList($model, 'houseTypeIds', $houseTypes, array('class'=>'form-control','separator'=>'&nbsp;')) : '<span class="help-inline">'.CHtml::link('【请先添加户型】',array('houseTypeEdit','hid'=>$hid)).'</span>'; ?>
             </div>
             <div class="col-xs-4"><?php echo $form->error($model, 'sale_total') ?></div>
         </div>
         <div class="form-group">
             <label class="col-xs-3 control-label">状态</span></label>
             <div class="col-xs-6">
                 <?php echo $form->radioButtonList($model, 'status', PlotBuildingExt::getStatus(), array('class'=>'form-control','separator'=>'&nbsp;','template'=>'<label>{input} {label}</label>')); ?>
             </div>
         </div>

         <div class="form-group">
             <label class="col-xs-3 control-label"></label>
             <div class="col-xs-5">
                 <button type="submit" class="btn green">保存</button>
                 <?php echo CHtml::link('返回', $this->createUrl('buildingList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
             </div>
         </div>

     </div>
     <?php $this->endWidget(); ?>
 </div>
