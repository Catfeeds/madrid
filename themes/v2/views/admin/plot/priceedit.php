<?php
$this->pageTitle = '价格动态编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-3 control-label">时间<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <div class="input-group date form_datetime">
                    <?php echo $form->textField($model,'created',array('class'=>'form-control','value'=>($model->created?date('Y-m-d',$model->created):''))); ?>
                    <span class="input-group-btn">
                      <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                   </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">类别</label>
            <div class="col-xs-3">
                <?php echo $form->dropDownList($model, 'jglb', $jglb, array('class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-3">
                <?php echo $form->dropDownList($model,'mark',PlotPriceExt::$mark,array('class'=>'form-control pull-right','style'=>'width:auto;')); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model,'price',array('class'=>'form-control input-small input-inline','placeholder'=>'此处填写价格')) ?>
                <?php echo $form->dropDownList($model,'unit',PlotPriceExt::$unit,array('class'=>'form-control input-small input-inline')) ?>
                <label>
                    <?php echo CHtml::checkBox('set_new') ?> 同步设为楼盘最新价
                </label>
            </div>
            <div class="col-xs-2"><?php echo $form->error($model, 'price') ?><?php echo $form->error($model, 'unit') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">描述<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->TextArea($model,'description',array('class'=>'form-control','rows'=>'5')) ?>
            </div>
            <div class="col-xs-4"><?php echo $form->error($model, 'description') ?></div>
        </div>
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9 text-center">
                    <?php echo $form->hiddenField($model, 'hid'); ?>
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回', $this->createUrl('plot/pricelist',array('hid'=>($model->hid ? $model->hid : $hid))),array('class'=>'btn green')); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <!-- </form>-->
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
