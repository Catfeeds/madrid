<div class="item" data-id="<?php echo $index?>">
    <div class="form-group">
        <label class="col-xs-3 control-label">子标题<span class="required" aria-required="true">*</span></label>
            <span class="tooltips fa fa-trash-o" title="删除该项" style="cursor:pointer;">删除该项</span>
        <div class="col-xs-5">
            <?php echo CHtml::activeTextField($model, $field.'['.$index.'][title]', array('class'=>'form-control')); ?>
        </div>
        <div class="col-xs-4"><?php echo CHtml::error($model, $field.'['.$index.'][title]') ?></div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label">内容<span class="required" aria-required="true">*</span></label>
        <div class="col-xs-5">
            <?php echo CHtml::activeTextArea($model, $field.'['.$index.'][content]', array('rows'=>5,'class'=>'form-control')); ?>
        </div>
        <div class="col-xs-4"><?php echo CHtml::error($model, $field.'['.$index.'][content]') ?></div>
    </div>
    <div class="form-group">
        <label class="col-xs-3 control-label">配图<span class="required" aria-required="true">*</span></label>
        <div class="col-xs-5">
            <?php $this->widget('FileUpload',array('model'=>$model, 'attribute'=>$field.'['.$index.'][image]','mode'=>2,'width'=>300,'id'=>$field.'_'.$index)) ?>
        </div>
        <div class="col-xs-4"><?php echo CHtml::error($model, $field.'['.$index.'][image]') ?></div>
    </div>
</div>
