<?php
/**
 * 分类添加编辑
 * @author 19gris
 * @date 2015-09-23
 */
$this->pageTitle = '编辑分类';
$this->breadcrumbs = array($this->pageTitle);
?>

<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-3 control-label">分类名称</label>
            <div class="col-md-5">
                <?php echo $form->textField($cate,'name',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($cate, 'name') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">父分类<span class="required" aria-required="true">*</span></label>
            <div class="col-md-5">
                <?php echo $form->dropDownList($cate,'parent',$catelist,array('class'=>'form-control','multiple'=>false,'encode'=>false)) ?>
            </div>
            <div class="col-md-4"><?php echo $form->error($cate, 'parent') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">分类排序</label>
            <div class="col-md-4">
                <?php echo $form->textField($cate,'sort',array('class'=>'form-control')) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">分类状态</label>
            <div class="col-md-4 radio-list">
                <?php echo $form->radioButtonList($cate,'status', AskCateExt::$status,array('separator'=>'','template'=>'<label>{input} {label}</label>')) ?>
            </div>
        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <!--<?php echo CHtml::link('返回',$this->createAbsoluteUrl('arealist'),array('class'=>'btn default')) ?>-->
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>