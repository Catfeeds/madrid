<?php
$this->pageTitle = '添加知识库分类';
$this->breadcrumbs = array('知识库分类管理',$this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-2 control-label">分类名称<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'name',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'name') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">分类拼音<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'pinyin',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'pinyin') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">父类id<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'parent',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'parent') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">分类排序<span class="required" aria-required="true">*</span></label>
            <div class="col-md-4">
                <?php echo $form->textField($model,'sort',array('class'=>'form-control')) ?>
            </div>
            <div class="col-md-2"><?php echo $form->error($model, 'sort') ?></div>
        </div>
        <div class="form-group">
            <label class="col-md-2" style="text-align: right;">wap展示</label>
            <div class="col-md-4 radio-list">
                <?php echo $form->radioButtonList($model, 'wap_show',BaikeCateExt::$wap_show, array('separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2" style="text-align: right;">分类状态</label>
            <div class="col-md-4 radio-list">
                <?php echo $form->radioButtonList($model, 'status',BaikeCateExt::$status, array('separator'=>'','template'=>'<label>{input} {label}</label>')); ?>
            </div>
        </div>


        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-2 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回',Yii::app()->user->returnUrl,array('class'=>'btn default')) ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>
