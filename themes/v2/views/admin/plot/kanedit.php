<?php
/**
 * Created by PhpStorm.
 * User: wanggris
 * Date: 15-9-11
 * Time: 下午2:54
 */

$this->pageTitle = '看房团新建/编辑';
$this->breadcrumbs = array($this->pageTitle);
?>

<?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
<div class="form-group">
    <label class="col-md-2 control-label">标题</label>
    <div class="col-md-6">
        <?php echo $form->textField($kan, 'title', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'title') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">楼盘</label>
    <div class="col-md-6">
        <?php echo $form->textField($kan, 'hids', array('class'=>'form-control','data-houses'=>$select2Plots)); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'hids') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">集合时间</label>
    <div class="col-md-3">
        <div class="input-group date form_datetime">
            <?php echo $form->textField($kan,'gather_time',array('class'=>'form-control gather_time','value'=>($kan->gather_time ? date('Y-m-d H:i', $kan->gather_time) : ''))); ?>
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">集合地点</label>
    <div class="col-md-6">
        <?php echo $form->textField($kan, 'location', array('class'=>'form-control location')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'location') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">截止时间</label>
    <div class="col-md-3">
        <div class="input-group date form_datetime1">
            <?php echo $form->textField($kan,'expire',array('class'=>'form-control stop_time', 'value'=>($kan->expire?date('Y-m-d', $kan->expire):'') )); ?>
            <span class="input-group-btn">
          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
       </span>
        </div>
    </div>
    <div class="col-md-2"><p class="err_time" style="color: #6e0009;width: 280px;"></p></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">回顾链接</label>
    <div class="col-md-6">
        <?php echo $form->textField($kan, 'url', array('class'=>'form-control' , 'placeholder'=>'输入的网址请以http://开头')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'url') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">默认人数</label>
    <div class="col-md-2">
        <?php echo $form->textField($kan, 'stat', array('class'=>'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'stat') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="col-md-6">
        <div class="radio-list">
            <?php echo $form->radioButtonList($kan,'status', PlotKanExt::$status,array('class'=>'radio-inline', 'separator'=>'&nbsp;&nbsp;')) ?>
        </div>
    </div>
    <div class="col-md-2"><?php echo $form->error($kan, 'status') ?></div>
</div>

<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn green">保存</button>
            <?php echo CHtml::link('返回',Yii::app()->user->returnUrl,array('class'=>'btn default')) ?>
        </div>
    </div>
</div>
<?php $this->endWidget() ?>
<?php

//Select2
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/select2/select2_locale_zh-CN.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2.css');
Yii::app()->clientScript->registerCssFile('/static/admin/pages/css/select2_custom.css');

Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js', CClientScript::POS_END, array('charset'=> 'utf-8'));

Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

$js = "
            $(function(){
               $('.select2').select2({
                  placeholder: '请选择',
                  allowClear: true
               });

					var getHousesAjax =
						 {
							url: '".$this->createUrl('/admin/plot/AjaxGetHouse')."',"."
							dataType: 'json',
							delay: 250,
							data: function (params) {
								return {
									kw:params
								};
							},
							results:function(data){
								var items = [];

								 $.each(data.results,function(){
								 	var tmp = {
								 		id : this.id,
								 		text : this.name
								 	}
								 	items.push(tmp);
								});

								return {
									results: items
								};
							},
							processResults: function (data, page) {
								var items = [];

								 $.each(data.msg,function(){
								 	var tmp = {
								 		id : this.id,
								 		text : this.title
								 	}
								 	items.push(tmp);
								});

								return {
									results: items
								};
							}
						}

					var houses_edit = $('#PlotKanExt_hids');
					var data = {};
					if( houses_edit.length && houses_edit.data('houses') ){
						data = eval(houses_edit.data('houses'));
					}

					$('#PlotKanExt_hids').select2({
						multiple:true,
						ajax: getHousesAjax,
						language: 'zh-CN',
						initSelection: function(element, callback){
							callback(data);
						}
					});

                 $('.form_datetime').datetimepicker({
                     autoclose: true,
                     isRTL: Metronic.isRTL(),
                     format: 'yyyy-mm-dd hh:ii',
                     // minView: 'm',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

                 $('.form_datetime1').datetimepicker({
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

<script>
    <?php Tools::startJs(); ?>

    $('.gather_time').focus(function(){
        $('.green').attr("disabled", false);
        $('.err_time').html('');
    });
    $('.stop_time').focus(function(){
        $('.green').attr("disabled", false);
        $('.err_time').html('');
    });
    $('.date-set').focus(function(){
        $('.green').attr("disabled", false);
        $('.err_time').html('');
    });

    $('.green').click(function(){
        var gathertime = $('.gather_time').val();//集合时间
        var stoptime = $('.stop_time').val();//截止时间
        var timegather = get_time(gathertime);
        var timestop = get_time(stoptime);
        if(timegather > timestop){
            $('.err_time').html('');
            $('.green').attr("disabled", false);
        }else{
            $('.err_time').html('集合时间须大于截止时间');
            $('.green').attr("disabled", true);
        }
    });

    function get_time(dateStr)
    {
        var newstr = dateStr.replace(/-/g,'/');
        var date =  new Date(newstr);
        var time_str = date.getTime().toString();
        return time_str;
    }

    <?php Tools::endJs('js') ?>
</script>
