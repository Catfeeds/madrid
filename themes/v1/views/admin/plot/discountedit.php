<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '优惠信息新建/编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-3 control-label">开始时间<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <div class="input-group date form_datetime">
                    <?php echo $form->textField($discount,'start',array('class'=>'form-control','value'=>($discount->start?date('Y-m-d',$discount->start):''))) ?>
                    <span class="input-group-btn">
                      <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                   </span>
                </div>
            </div>
            <div class="col-xs-4"><?php echo $form->error($discount, 'start') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">结束时间<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <div class="input-group date form_datetime">
                    <?php echo $form->textField($discount,'expire',array('class'=>'form-control','value'=>($discount->expire?date('Y-m-d',$discount->expire):''))); ?>
                    <span class="input-group-btn">
                      <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                   </span>
                </div>
            </div>
            <div class="col-xs-4"><?php echo $form->error($discount, 'expire') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">标题<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($discount,'title',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($discount, 'title') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">链接<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->urlField($discount,'url',array('class'=>'form-control','rows'=>'5')) ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($discount, 'url') ?></div>
        </div>

        <div class="" style="height:120px;"> </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回', $this->createAbsoluteUrl('plot/discountlist',array('hid'=>($discount->hid ? $discount->hid : $hid))),array('class'=>'btn green')); ?>
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

