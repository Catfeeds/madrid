<?php
$this->pageTitle = $model->id ? '添加推荐位':'编辑推荐位';
$this->breadcrumbs = array('推荐管理',$this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-2 control-label">推荐位名称<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'name',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'name') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label"><?php echo $form->label($model,'pinyin') ?><span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'pinyin',array('class'=>'form-control','disabled'=>!$model->isNewRecord)) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'pinyin') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">父分类<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->dropDownList($model,'parent',CHtml::listData(Tools::menuMake($this->recomCate,-1,'id'),'id','name'),array('class'=>'form-control','encode'=>false, 'empty'=>array(0=>'--根节点--'))) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'parent') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2" style="text-align: right;">分类状态</label>
            <div class="col-md-4 radio-list">
                <?php echo $form->radioButtonList($model, 'status', ResoldRecomCateExt::$status, array('separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
            </div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回',$this->createUrl('catelist'),array('class'=>'btn default')) ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
