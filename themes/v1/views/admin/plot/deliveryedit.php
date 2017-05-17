<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '交房时间编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-2 control-label">标题<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-8">
                <?php echo $form->textField($delivery,'title',array('class'=>'form-control')) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-2 control-label">时间<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-4">
                <div class="input-group date form_datetime">
                    <?php echo $form->textField($delivery,'delivery_time',array('class'=>'form-control','value'=>($delivery->delivery_time?date('Y-m-d',$delivery->delivery_time):''))); ?>
                    <span class="input-group-btn">
                  <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
               </span>
                </div>
            </div>
            <label > <?php echo CHtml::checkBox('set_new')?> 设置为最新交房时间 </label>
        </div>

        <div class="form-group" >
            <label class="col-xs-2 control-label">详情<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-8">
                <?php echo $form->TextArea($delivery,'content',array('class'=>'form-control','rows'=>8)) ?>
            </div>
        </div>

        <div style="height:100px"> </div>
        <div class="form-actions">
            <div class="row">
                <div class="text-center col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回', $this->createAbsoluteUrl('plot/deliverylist',array('hid'=>$hid)),array('class'=>'btn default'));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div>
<?php
//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));
$js = "
            $(function(){

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });


            });


            ";

Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);
?>

