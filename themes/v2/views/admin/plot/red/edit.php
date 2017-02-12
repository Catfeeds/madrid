<?php
$this->pageTitle = '楼盘红包编辑';
$this->breadcrumbs = array($this->pageTitle);
 ?>
<div class="portlet-body">
     <?php $form = $this->beginWidget('HouseForm',array('htmlOptions'=>array('class'=>'form-horizontal'))) ?>
     <div class="form-body">
         <div class="form-group">
            <label class="col-xs-3 control-label">标题<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'title',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'title') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">副标题</label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'sub_title',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'sub_title') ?></div>
        </div>
         <div class="form-group">
                <label class="col-xs-3 control-label text-nowrap">开始领取时间</label>
                <div class="col-xs-5">
                    <div class="input-group date form_datetime" >
                        <?php echo $form->textField($model,'start_time',array('class'=>'form-control','value'=>($model->start_time?date('Y-m-d',$model->start_time):''))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                </div>
        </div>
        <div class="form-group">
                <label class="col-xs-3 control-label text-nowrap">结束领取时间</label>
                <div class="col-xs-5">
                    <div class="input-group date form_datetime" >
                        <?php echo $form->textField($model,'end_time',array('class'=>'form-control','value'=>($model->end_time?date('Y-m-d',$model->end_time):''))); ?>
                        <span class="input-group-btn">
                          <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                       </span>
                    </div>
                </div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">红包额度<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'amount',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'amount') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">红包已领人数<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'got_num',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'got_num') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">默认领取人数<span class="required" aria-required="true">*</span></label>
            <div class="col-xs-5">
                <?php echo $form->textField($model,'total_num',array('class'=>'form-control')) ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'total_num') ?></div>
        </div>
        <div class="form-group">
            <label class="col-xs-3 control-label">状态</label>
            <div class="col-xs-5">
                <?php echo $form->radioButtonList($model, 'status', PlotRedExt::$status, array('separator' => '')); ?>
            </div>
            <div class="col-xs-3"><?php echo $form->error($model, 'status') ?></div>
        </div>
         <div class="form-group">
             <label class="col-xs-3 control-label"></label>
             <div class="col-xs-5">
                 <button type="submit" class="btn green">保存</button>
                 <?php echo CHtml::link('返回', $this->createUrl('redList',array('hid'=>$hid)),array('class'=>'btn green')); ?>
             </div>
         </div>
        <div style="height: 20px"></div>
     </div>
     <?php $this->endWidget(); ?>
     <?php
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
 </div>
