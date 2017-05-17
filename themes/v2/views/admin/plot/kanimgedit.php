<?php
/**
 * Created by PhpStorm.
 * User: sc
 * Date: 2015/12/18
 * Time: 9:36
 */
$this->pageTitle = '看房团图片新建/编辑';
$this->breadcrumbs = array($this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">标题</label>
    <div class="col-md-6">
        <?php echo $form->textField($img, 'title', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($img, 'title') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($img,'img') ?></label>
    <div class="col-md-4">
        <?php $this->widget('FileUpload',array('model'=>$img, 'attribute'=>'img','mode'=>2,'width'=>300,'height'=>300)) ?>
        <span class="help-inline">（图片尺寸宽度大于270，最佳尺寸270*200）</span>
    </div>
    <div class="col-md-2"><?php echo $form->error($img,'img') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="col-md-6">
        <div class="radio-list">
            <?php echo $form->radioButtonList($img,'status', PlotKanImgExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')) ?>
        </div>
    </div>
    <div class="col-md-2"><?php echo $form->error($img, 'status') ?></div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('/admin/plot/kanimg',array('kid'=>$kid)),array('class'=>'btn default')) ?>
        </div>
    </div>
</div>

<?php $this->endWidget() ?>
<?php

//Select2
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
// Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2-bootstrap.css');

//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
// Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);
?>


<script type="text/javascript">
    <?php Tools::startJs(); ?>
    $(function(){
        $('.select2').select2({
            placeholder: '请选择',
            allowClear: true
        });

        $('.form_datetime').datetimepicker({
            autoclose: true,
            isRTL: Metronic.isRTL(),
            format: 'yyyy-mm-dd',
            minView: 'month',
            language: 'zh-CN',
            pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
        });
    });
    <?php Tools::endJs('js'); ?>
</script>