<?php
$this->pageTitle = '价格走势新建/编辑';
$this->breadcrumbs = array('二手房价格走势' , '价格走势新建/编辑');
?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">时间</label>
    <div class="col-md-2">
        <div class="input-group date form_datetime">
            <?php echo $form->textField($model, 'formatTime', array('class' => 'form-control')); ?>
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
    <div class="col-md-2"><?php echo $form->error($model, 'formatTime') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">价格</label>
    <div class="col-md-6" style="padding-left: 0px">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">市二手房房价</span>
                <?php echo $form->textField($model, 'data[0]', array('class' => 'form-control')); ?>
            </div>
        </div>
    </div>
</div>

<?php foreach ($area as $k => $v): ?>
    <div class="form-group">
        <label class="col-md-2 control-label"></label>
        <div class="col-md-6" style="padding-left: 0px">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><?php echo $v->name; ?></span>
                    <?php echo $form->textField($model, 'data['.$v->id.']', array('class' => 'form-control')); ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回', Yii::app()->user->returnUrl, array('class' => 'btn default')) ?>
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
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset' => 'utf-8'));

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

$js = "
            $(function(){
               $('.select2').select2({
                  placeholder: '请选择',
                  allowClear: true
               });

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm',
                     minView: 'year',
                     maxView: 'year',
                     startView: 'year',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

            });

            ";
Yii::app()->clientScript->registerScript('add', $js, CClientScript::POS_END);
?>
