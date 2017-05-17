<?php
$this->pageTitle = '特价房新建/编辑';
$this->breadcrumbs = array('房源管理' => $_GET['referrer'], '特价房新建/编辑');
?>
<?php $form = $this->beginWidget('HouseForm', array('htmlOptions' => array('class' => 'form-horizontal'))) ?>

<div class="form-group">
	<label class="col-md-2 control-label">楼盘</label>
	<div class="col-md-6">
            <?php echo $form->autocomplete($special, 'hid', array('class'=>'form-control','data-init-text'=>$special->id ? $special->plot->title : '', 'url'=>$this->createUrl('plot/ajaxGetHouse')));?>
	</div>
	<div class="col-md-2"><?php echo $form->error($special, 'hid') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">标题</label>
    <div class="col-md-6">
        <?php echo $form->textField($special, 'title', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'title') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">排序</label>
    <div class="col-md-6">
        <?php echo $form->textField($special, 'sort', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'sort') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">价格</label>
    <div class="col-md-6" style="padding-left: 0px">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">原价</span>
                <?php echo $form->textField($special, 'price_old', array('class' => 'form-control')); ?>
            </div>
			<span class="help-block"><?php echo $form->error($special,'price_old');  ?></span>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">现价</span>
                <?php echo $form->textField($special, 'price_new', array('class' => 'form-control')); ?>
            </div>
			<span class="help-block"><?php echo $form->error($special,'price_new');  ?></span>
        </div>
        <div class="col-md-4">
            万元/套
        </div>
    </div>

</div>
<div class="form-group">
    <label class="col-md-2 control-label">房号</label>
    <div class="col-md-6">
        <?php echo $form->textField($special, 'room', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'room') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">面积</label>
    <div class="col-md-6">
        <?php echo $form->textField($special, 'size', array('class' => 'form-control')); ?>
    </div>
    <!--<span class="help-inline"> ㎡ </span>-->
    <div class="col-md-2"><?php echo $form->error($special, 'size') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">居室</label>
    <div class="col-md-6">
        <?php echo $form->textField($special, 'bed_room', array('class' => 'form-control')); ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'bed_room') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label">截止时间</label>
    <div class="col-md-2">
        <div class="input-group date form_datetime">
            <?php echo $form->textField($special, 'end_time', array('class' => 'form-control')); ?>
            <span class="input-group-btn">
                <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($special, 'image') ?></label>
    <div class="col-md-4">
        <?php $this->widget('FileUpload', array('model' => $special, 'attribute' => 'image', 'mode' => 2, 'width' => 300, 'height' => 300)) ?>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'image') ?></div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label"><?php echo $form->label($special, 'housetype_img') ?></label>
    <div class="col-md-4">
        <?php $this->widget('FileUpload', array('multi'=>true, 'mode' => 2, 'width' => 300, 'height' => 300,'callback'=>'function(data){uploaded(data)}')) ?>
        <span class="help-inline">（图片尺寸宽度大于640，最佳尺寸640*425）</span>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'housetype_img') ?></div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-6">
        <div id="uploader" class="wu-example">
            <div id="fileList" class="uploader-list" data-name-val="PlotSpecialExt[housetype_img][]">
                <?php if(isset($special->housetype_img) && !empty($special->housetype_img)): ?>
                    <?php foreach($special->housetype_img as $v): ?>
                        <div class="col-md-3 text-center">
                            <a href=<?php echo ImageTools::fixImage($v) ?> target="_blank" class="thumbnail" style="margin-bottom:5px">
                                <img src=<?php echo ImageTools::fixImage($v) ?>>
                            </a>
                            <a href="javascript:;" class="btn btn-sm  rmfile" data-id="0">删除</a>
                            <input value=<?php echo $v?> name="PlotSpecialExt[housetype_img][]" id="SchoolExt_pic" type="hidden">
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>




<div class="form-group">
    <label class="col-md-2 control-label">状态</label>
    <div class="col-md-6">
        <div class="radio-list">
            <?php echo $form->radioButtonList($special, 'status', PlotSpecialExt::$status, array('class' => 'radio-inline', 'separator' => '&nbsp;&nbsp;')) ?>
        </div>
    </div>
    <div class="col-md-2"><?php echo $form->error($special, 'status') ?></div>
</div>
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
Yii::app()->clientScript->registerCssFile('/static/global/plugins/select2/select2-bootstrap.css');
//boostrap datetimepicker
Yii::app()->clientScript->registerCssFile('/static/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css');
Yii::app()->clientScript->registerScriptFile('/static/global/plugins/bootstrap-daterangepicker/moment.min.js', CClientScript::POS_END);
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
                     format: 'yyyy-mm-dd',
                     minView: 'month',
                     language: 'zh-CN',
                     pickerPosition: (Metronic.isRTL() ? 'bottom-right' : 'bottom-left'),
                 });

            });


            ";
Yii::app()->clientScript->registerScript('add', $js, CClientScript::POS_END);
?>

<script>
    <?php Tools::startJs();?>
        function uploaded(data){
            var url = data.msg.url;
            var html = '<div class="col-md-3 text-center"><a href="'+url+'" target="_blank" class="thumbnail" style="margin-bottom:5px"><img src="'+url+'"></a><a href="javascript:;" class="btn btn-sm  rmfile" data-id="0">删除</a> <?php echo $form->hiddenField($special, 'housetype_img[]',array('value'=>"'+data.msg.pic+'",'encode'=>false)); ?></div>';
           $('#fileList').append(html);
        }

                    //移除图片
        $(".rmfile").live("click",function(){
            $(this).parent().remove();
        });

    <?php Tools::endJs('js');?>
</script>
