<?php
$this->pageTitle = '帮助新建/编辑';
$this->breadcrumbs = array('帮助管理', $this->pageTitle);
?>
<?php $this->widget('ext.ueditor.UeditorWidget',array('id'=>'ResoldHelpExt_content')); ?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
    <div class="form-group">
        <label class="col-md-2 control-label">标题<span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            <?php echo $form->textField($model, 'title', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'title') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">关键字<span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            <?php echo $form->textField($model, 'keyword', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'keyword') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">外链</label>
        <div class="col-md-4">
            <?php echo $form->textField($model, 'url', array('class' => 'form-control')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'url') ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">内容</label>
        <div class="col-md-8">
            <?php echo $form->textArea($model, 'content', array('id'=>'ResoldHelpExt_content')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'content')  ?></div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">状态</label>
        <div class="col-md-4 radio-list">
            <?php echo $form->radioButtonList($model, 'status', ResoldHelpExt::$status_array, array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')); ?>
        </div>
        <div class="col-md-2"><?php echo $form->error($model, 'status') ?></div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <button type="submit" class="btn green">保存</button>
                <?php echo CHtml::link('返回',Yii::app()->user->returnUrl, array('class' => 'btn default')) ?>
            </div>
        </div>
    </div>
<?php $this->endWidget() ?>