<?php
$this->pageTitle = '前台页面配置';
$this->breadcrumbs = array('买房顾问',$this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
<div class="note note-success">基本设置</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($model,'siteName') ?></label>
    <div class="col-md-4">
        <?php echo $form->textField($model, 'siteName', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($model,'siteName') ?></div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('/admin/common/index'),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>



<script type="text/javascript">
<?php Tools::startJs(); ?>

<?php Tools::endJs('js'); ?>
</script>
