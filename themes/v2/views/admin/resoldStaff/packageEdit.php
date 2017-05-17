<?php
$this->pageTitle = '职员套餐编辑';
$this->breadcrumbs = array($this->pageTitle);
?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>
<div class="col-md-4">
<div class="form-group">
    <label class="col-md-2 control-label">职员姓名</label>
    <div class="col-md-8">
            <?php echo $form->textField($staff, 'name', array('class' => 'form-control','readonly'=>'readonly')); ?>

            <?php echo $form->textField($staff, 'id', array('class' => 'form-control hide','readonly'=>'readonly')); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">选择套餐</label>
    <div class="col-md-8">
        <?php echo $form->dropDownList($staff,'package', ResoldTariffPackageExt::getPackages() ,array('prompt'=>'--请选择--','class'=>'form-control')); ?>                    
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">套餐加急数</label>
    <div class="col-md-8">
            <?php echo $form->textField($staff, 'hurry_num', array('class' => 'form-control')); ?>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">套餐到期时间</label>
    <div class="col-md-8">
        <div class="input-group date form_datetime" style="width: 300px">
            <?php echo $form->textField($staff,'expireTime',array('class'=>'form-control','value'=>($staff->expireTime?date('Y-m-d',$staff->expireTime):''))); ?>
            <span class="input-group-btn">
              <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
           </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">账号到期时间</label>
    <div class="col-md-8">
        <div class="input-group date form_datetime" style="width: 300px">
            <?php echo $form->textField($staff,'id_expire',array('class'=>'form-control','value'=>($staff->id_expire?date('Y-m-d',$staff->id_expire):''))); ?>
            <span class="input-group-btn">
              <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
           </span>
        </div>
    </div>
</div>
<div style="height: 200px"></div>
<div class="col-md-12 center-block text-center">
    <div class="btn-group text-center">
        <button class="btn green-meadow col-md-offset-4">提交</button>
    </div>
</div>
</div>
<?php $this->endWidget() ?>
<?php
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js', CClientScript::POS_END);
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
