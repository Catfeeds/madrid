<?php
$this->pageTitle = '开关设置';
$this->breadcrumbs = array('站点设置',$this->pageTitle);
?>
<?php
$form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal')));
foreach($model->attributeNames() as $name):
?>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,$name) ?></label>
    <div class="col-md-10">
        <?php
            echo $form->radioButtonList($model, $name, array(0=>'关闭', 1=>'启用'), array('class'=>'form-control', 'template'=>'<label>{input} {label}</label>', 'separator'=>'',));
        ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,$name) ?></div>
</div>
<?php
endforeach;
?>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('/admin/common/index'),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget();?>
