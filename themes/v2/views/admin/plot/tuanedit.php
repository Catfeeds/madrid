<?php
$this->pageTitle = '特惠团新建/编辑';
$this->breadcrumbs = array('房源管理'=>$_GET['referrer'],$this->pageTitle);
?>


<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>

<div class="form-group">
	<label class="col-md-2 control-label">楼盘</label>
	<div class="col-md-6">
            <?php echo $form->autocomplete($tuan, 'hid', array('class'=>'form-control', 'url'=>$this->createUrl('plot/ajaxGetHouse')));?>
	</div>
	<div class="col-md-2"><?php echo $form->error($tuan, 'hid') ?></div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">标题</label>
	<div class="col-md-6">
		<?php echo $form->textField($tuan, 'title', array('class'=>'form-control')); ?>
	</div>
	<div class="col-md-2"><?php echo $form->error($tuan, 'title') ?></div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">副标题</label>
	<div class="col-md-6">
		<?php echo $form->textField($tuan, 's_title', array('class'=>'form-control')); ?>
	</div>
	<div class="col-md-2"><?php echo $form->error($tuan, 's_title') ?></div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">截止时间</label>
	<div class="col-md-2">
		<div class="input-group date form_datetime">
		   <?php echo $form->textField($tuan,'end_time',array('class'=>'form-control')); ?>
		   <span class="input-group-btn">
			  <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
		   </span>
		</div>
	 </div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">封面图</label>
	<div class="col-md-6">
		<div id="uploader1" class="wu-example">
		   <div class="btns">
			  <!--<div id="cover_img">选择文件</div>-->
			  <?php $this->widget('FileUpload',array('model'=>$tuan,'attribute'=>'pc_img','inputName'=>'pc_img','removeCallback'=>"$('#cover_img').html('')")); ?>
		   </div>
		</div>
		<div id="singlePicyw1"></div>
	 </div>
	<div class="col-md-2"><?php echo $form->error($tuan, 'pc_img') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($tuan,'wap_img') ?></label>
    <div class="col-md-4">
        <?php $this->widget('FileUpload',array('model'=>$tuan, 'attribute'=>'wap_img','mode'=>2,'width'=>300,'height'=>300)) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($tuan,'wap_img') ?></div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label">链接</label>
	<div class="col-md-6">
		<?php echo $form->urlField($tuan, 'url', array('class'=>'form-control', 'placeholder'=>'输入的网址请以http://开头')); ?>
	</div>
	<div class="col-md-2"><?php echo $form->error($tuan, 'url') ?></div>
</div>
<div class="form-group">
	<label class="col-md-2 control-label">状态</label>
	<div class="col-md-6">
		<div class="radio-list">
		   <?php echo $form->radioButtonList($tuan,'status', PlotTuanExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')) ?>
		</div>
	 </div>
	<div class="col-md-2"><?php echo $form->error($tuan, 'status') ?></div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',$this->createUrl('tuanlist'),array('class'=>'btn default')) ?>
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

$js = "
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
            ";
Yii::app()->clientScript->registerScript('add',$js,CClientScript::POS_END);

?>
