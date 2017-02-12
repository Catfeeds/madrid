<?php
$this->pageTitle = '学校区域/编辑';
$this->breadcrumbs = array('学校区域管理',$this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label text-nowrap">学区</label>
    <div class="col-md-6">
        <?php echo $form->dropDownList($data, 'area', $area, array('empty' => '请选择区域','class'=>'form-control')); ?>
    </div>
    <div class="col-md-12"><?php echo $form->error($data, 'area'); ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">链接</label>
    <div class="col-md-6">
        <?php echo $form->textField($data,'url',array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($data, 'url'); ?></div>
</div>

<div class="form-group">
   <label class="col-md-2 control-label">学区简介</label>
   <div class="col-md-6">
       <?php echo $form->TextArea($data, 'description', array('class'=>'form-control','rows'=>5)); ?>
   </div>
    <div class="col-md-2"><?php echo $form->error($data, 'description'); ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">小学学区示意图</label>
    <div class="col-md-5">
        <?php $this->widget('FileUpload',array('model'=>$data, 'attribute'=>'xx_pic','mode'=>2,'width'=>300,'height'=>300)) ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">中学学区示意图</label>
    <div class="col-md-5">
        <?php $this->widget('FileUpload',array('model'=>$data, 'attribute'=>'zx_pic','mode'=>2,'width'=>300,'height'=>300)) ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="radio-list col-md-6">
        <?php echo $form->radioButtonList($data, 'status', SchoolAreaExt::$status, array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;')) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($data, 'status'); ?></div>
</div>

<div class="form-actions">
        <div class="row">
                <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green">保存</button>
                        <?php echo CHtml::link('返回',Yii::app()->user->returnUrl,array('class'=>'btn default')) ?>
                </div>
        </div>
</div>

<?php $this->endWidget() ?>

