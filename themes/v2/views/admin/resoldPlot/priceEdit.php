<?php
$this->pageTitle = '二手房价格动态编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<div class="portlet-body">
    <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
    <div class="form-body">
        <div class="form-group">
            <label class="col-xs-3 control-label">时间<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <div class="input-group date form_datetime">
                    <?php echo $form->textField($model,'new_time',array('class'=>'form-control','value'=>($model->new_time?date('Y-m-d',$model->new_time):date('Y-m-d',time())))); ?>
                    <span class="input-group-btn">
                      <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                   </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">价格<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'price',array('class'=>'form-control input-inline','placeholder'=>'此处填写价格')) ?><span>元/m<sup>2</sup></span>
            </div>
            <div class="col-xs-2"><?php echo $form->error($model, 'price') ?></div>
        </div>
        <div class="form-actions" style="margin-top: 200px;">
            <div class="row">
                <div class="col-md-offset-3 col-md-9 text-center">
                    <?php echo $form->hiddenField($model, 'hid'); ?>
                    <button type="submit" class="btn green">保存</button>
                    <?php echo CHtml::link('返回', $this->createUrl('resoldPlot/priceList',array('hid'=>($model->hid ? $model->hid : $hid))),array('class'=>'btn green')); ?>
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
